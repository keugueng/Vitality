import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Store ziggy data reference that will be updated by Inertia
let ziggyData = { routes: {}, url: '', port: null };

// Simple route helper to replace Ziggy
function route(name, params = {}) {
    // When called without arguments, return a route object with methods
    if (!name) {
        return {
            current: function(routeName) {
                if (!routeName) return false;
                
                const currentPath = window.location.pathname;
                const routes = ziggyData?.routes || {};
                const targetRoute = routes[routeName]?.uri;
                
                if (!targetRoute) return false;
                
                // Simple exact match or pattern match
                const normalizedCurrent = currentPath.replace(/^\//, '');
                const normalizedTarget = targetRoute.replace(/^\//, '');
                
                // Check exact match
                if (normalizedCurrent === normalizedTarget) return true;
                
                // Check pattern match (for routes with parameters)
                const targetPattern = normalizedTarget.replace(/{[^}]+}/g, '[^/]+');
                const regex = new RegExp(`^${targetPattern}$`);
                return regex.test(normalizedCurrent);
            }
        };
    }
    
    const routes = ziggyData?.routes || {};
    let url = routes[name]?.uri;
    
    if (!url) {
        console.warn(`Route not found: ${name}`);
        return '#' + name;
    }
    
    // Replace route parameters
    Object.keys(params).forEach(key => {
        url = url.replace(`{${key}}`, params[key]);
        url = url.replace(`{${key}?}`, params[key] || '');
    });
    
    return '/' + url.replace(/^\//, '');
}

// Make route available globally
window.route = route;

const appName = 'Vitality Inside';

createInertiaApp({
    title: (title) => title ? `${title} — ${appName}` : appName,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        // Initialize ziggy data from initial page props
        if (props.initialPage?.props?.ziggy) {
            ziggyData = props.initialPage.props.ziggy;
        }
        
        // Listen for Inertia navigation to update ziggy data
        router.on('navigate', (event) => {
            if (event.detail?.page?.props?.ziggy) {
                ziggyData = event.detail.page.props.ziggy;
            }
        });
        
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({
                methods: {
                    route: window.route
                }
            });
        
        return app.mount(el);
    },
    progress: {
        color: '#11C7C9',
        showSpinner: false,
    },
});
