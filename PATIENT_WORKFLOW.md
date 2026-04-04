# Patient Workflow Analysis & Implementation Guide

## 1. CURRENT PATIENT WORKFLOW OVERVIEW

### A. Public-Facing Patient Journey

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                        PUBLIC PATIENT WORKFLOW                              │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  1. DISCOVERY                                                               │
│     ├── Home Page (/) - Hero, stats, featured programs                      │
│     ├── About (/about) - Dr. Rosati bio, mission                            │
│     ├── Blog (/blog) - Educational content                                  │
│     └── Shop (/shop) - Program catalog with filtering                       │
│                                                                             │
│  2. ENGAGEMENT                                                              │
│     ├── Program Detail - View program info, listen to preview               │
│     ├── Add to Cart - Individual programs                                  │
│     ├── Consultation (/consultation) - Book custom protocol                 │
│     │   └── Packages: Single (€58), Progress (€149), Transform (€239)      │
│     └── Subscription (/subscribe) - Monthly (€29) or Annual (€249)         │
│                                                                             │
│  3. CONVERSION                                                              │
│     ├── Cart (/cart) - Review items, Stripe/PayPal checkout                 │
│     ├── Checkout (/checkout) - Payment processing                           │
│     └── Success - Order confirmation, email delivery                        │
│                                                                             │
│  4. POST-PURCHASE                                                           │
│     ├── My Program (/my-program) - Access via code                          │
│     ├── User Dashboard (/pro) - For registered users                        │
│     │   ├── Programs tab - Access purchased programs                        │
│     │   ├── Orders tab - Order history                                      │
│     │   ├── Consultations tab - View booked consultations                   │
│     │   └── Subscription tab - Manage subscription                          │
│     └── Email delivery - Protocol links sent via email                      │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

### B. Practitioner (Pro) Patient Management Workflow

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     PRACTITIONER PATIENT WORKFLOW                           │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  PRACTITIONER QUALIFICATION                                                │
│  ├── User registers/is marked as is_pro = true                             │
│  ├── ProProfile auto-created (commission_rate: 20%)                         │
│  └── Access to /pro/patients and /pro/protocols                             │
│                                                                             │
│  PATIENT MANAGEMENT                                                         │
│  ├── Add Patient (/pro/patients)                                           │
│  │   └── Fields: name*, email, phone, age, gender, medical_history        │
│  │                                                                            │
│  ├── Assign Protocol (/pro/protocols)                                        │
│  │   └── Fields: patient*, program*, notes                                 │
│  │   └── Status: assigned → in_progress → completed                         │
│  │                                                                            │
│  ├── Track Progress                                                         │
│  │   └── sessions_done, progress_percent (0-100%)                           │
│  │   └── Update status via Protocols page                                   │
│  │                                                                            │
│  └── Patient List                                                           │
│      └── View all patients with assigned protocols                          │
│      └── Delete patient (cascade deletes protocols)                         │
│                                                                             │
│  PROTOCOL LIFECYCLE                                                         │
│  ┌────────────┐    ┌────────────┐    ┌────────────┐                       │
│  │  ASSIGNED  │ →  │  IN_PROG   │ →  │ COMPLETED  │                       │
│  └────────────┘    └────────────┘    └────────────┘                       │
│       ↓                  ↓                  ↓                               │
│   Pro assigns      Patient listens      Sessions done                     │
│   to patient       to protocol          Progress 100%                      │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

### C. Admin Patient/Consultation Management

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                      ADMIN CONSULTATION WORKFLOW                            │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  CONSULTATION LIFECYCLE                                                     │
│  ├── Patient books via /consultation                                       │
│  ├── Status: pending → in_progress → delivered → completed                  │
│  ├── Admin updates via /admin/consultations                                │
│  ├── Dr. Rosati creates custom protocol                                     │
│  └── Protocol delivered (protocol_url, protocol_notes, delivered_at)        │
│                                                                             │
│  PATIENT DATA ACCESS                                                        │
│  ├── Admin can view all patients (via database)                             │
│  ├── Admin can view all protocols                                           │
│  └── Admin manages commission settings for practitioners                    │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

## 2. DATABASE SCHEMA - PATIENT-RELATED TABLES

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                         PATIENT DATA MODELS                                 │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  ┌─────────────┐       ┌─────────────┐       ┌─────────────┐                │
│  │    users    │──────<│   patients  │>──────│patient_     │                │
│  │             │       │             │       │protocols    │                │
│  │ id          │       │ id          │       │             │                │
│  │ name        │       │ pro_user_id │──────>│ id          │                │
│  │ email       │       │ name        │       │ patient_id  │                │
│  │ is_pro      │       │ email       │       │ program_id  │>────┐          │
│  │             │       │ phone       │       │ status      │     │          │
│  └─────────────┘       │ age         │       │ sessions_   │     │          │
│         │              │ gender      │       │ done        │     │          │
│         │              │ medical_    │       │ progress_   │     │          │
│         │              │ history     │       │ percent     │     │          │
│         │              │ status      │       │ notes       │     │          │
│         │              └─────────────┘       └─────────────┘     │          │
│         │                                                       │          │
│         │              ┌─────────────┐       ┌─────────────┐    │          │
│         └─────────────>│   pro_users │       │   programs  │<───┘          │
│                        │             │       │             │                │
│                        │ id          │       │ id          │                │
│                        │ user_id     │<──────│ title       │                │
│                        │ commission_ │       │ emoji       │                │
│                        │ rate        │       │ price       │                │
│                        │ total_      │       │ audio_url   │                │
│                        │ commissions │       └─────────────┘                │
│                        └─────────────┘                                      │
│                                                                             │
│  ┌─────────────┐       ┌─────────────┐                                      │
│  │consultations│       │    orders   │       ┌─────────────┐                │
│  │             │       │             │──────<│ order_items │                │
│  │ id          │       │ id          │       │             │                │
│  │ user_id     │>──────│ user_id     │       │ order_id    │                │
│  │ package_type│       │ status      │       │ program_id  │>────┐         │
│  │ sessions_   │       │ total       │       └─────────────┘     │         │
│  │ count       │       └─────────────┘                           │         │
│  │ amount      │                                                   │         │
│  │ symptoms    │                    ┌─────────────┐               │         │
│  │ status      │                    │  programs   │<──────────────┘         │
│  │ protocol_   │                    │  (same)     │                         │
│  │ url         │                    └─────────────┘                         │
│  └─────────────┘                                                           │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

## 3. IDENTIFIED GAPS & MISSING FEATURES

### HIGH PRIORITY

| Gap | Impact | Solution |
|-----|--------|----------|
| Patient email notifications | Patients don't get confirmation emails | Add Notification system with email templates |
| Protocol delivery automation | Manual process for Dr. Rosati | Add file upload + auto-email on status change |
| Patient access without account | Only code-based access exists | Consider patient user accounts linked to practitioner |
| Session tracking per patient | No session-by-session tracking | Add `patient_sessions` table with dates |
| Reminder system | Patients may forget to listen | Add reminder notifications |

### MEDIUM PRIORITY

| Gap | Impact | Solution |
|-----|--------|----------|
| Patient notes/communication | No messaging between pro and patient | Add comments/notes thread per protocol |
| Progress photos/docs | No visual tracking | Add file attachments to patient_protocols |
| Patient self-reporting | Pro doesn't know if patient listened | Add patient feedback form |
| Subscription-based access | Patients buy individual programs | Consider practitioner subscription model |

### LOW PRIORITY

| Gap | Impact | Solution |
|-----|--------|----------|
| Patient mobile app | Web-only experience | Future: React Native app |
| Offline mode | No download capability | Add audio download with DRM |
| Analytics dashboard | No insights for pros | Add charts: adherence, completion rates |

## 4. REQUIRED IMPLEMENTATIONS

### A. Patient Notification System

```php
// New Model: PatientNotification
- patient_id (FK)
- type (email, sms, push)
- subject
- content
- sent_at
- read_at
- status (pending, sent, failed)
```

### B. Enhanced Protocol Delivery

```php
// Enhance PatientProtocol model
- audio_files (JSON array of assigned tracks)
- session_schedule (JSON: which days to listen)
- reminder_enabled (boolean)
- reminder_time (time)
```

### C. Patient Session Tracking

```php
// New Model: PatientSession
- patient_protocol_id (FK)
- session_number
- listened_at
- duration_seconds
- feedback_rating (1-5)
- feedback_notes
```

## 5. API ENDPOINTS NEEDED

| Endpoint | Method | Description |
|----------|--------|-------------|
| /api/patient/notifications | GET | List patient notifications |
| /api/patient/protocols | GET | List assigned protocols |
| /api/patient/protocols/{id}/progress | POST | Update listening progress |
| /api/patient/sessions | POST | Log a listening session |
| /api/practitioner/patients/{id}/notify | POST | Send message to patient |

## 6. NEXT STEPS - IMPLEMENTATION PRIORITY

1. **Fix Payment Configuration** ✅ DONE
   - Debug endpoint at /payment/config-status
   - Seeder for payment settings
   - Better error messages

2. **Add Patient Email Notifications** 🔄 NEXT
   - Create PatientNotification model + migration
   - Add email templates for: new protocol assigned, reminder, completion
   - Queue system for sending

3. **Protocol File Upload** 🔄 NEXT
   - Add file upload to PatientProtocol
   - Auto-generate secure access links
   - Email delivery on status change

4. **Patient Progress Tracking** 📋 PENDING
   - Create PatientSession model
   - Add session logging endpoint
   - Dashboard widget for pros

5. **Patient Feedback System** 📋 PENDING
   - Rating system after each session
   - Notes/communication thread
   - Pro notification on feedback

## 7. PATIENT WORKFLOW - COMPLETE USER STORIES

### As a Patient (Public User)
```gherkin
Feature: Discover and purchase programs
  As a visitor
  I want to browse and buy bio-resonance programs
  So that I can improve my health

  Scenario: Browse programs
    Given I am on the home page
    When I click "Explorer les programmes"
    Then I see the shop with all available programs

  Scenario: Purchase a program
    Given I am viewing a program
    When I click "Ajouter au panier"
    And I proceed to checkout
    And I pay with Stripe/PayPal
    Then I receive an email with my access code
    And I can access my program at /my-program
```

### As a Patient of a Practitioner
```gherkin
Feature: Follow assigned protocol
  As a patient with a practitioner
  I want to follow my assigned protocol
  So that I can get better under professional guidance

  Scenario: Receive protocol assignment
    Given my practitioner assigns me a protocol
    When the assignment is saved
    Then I receive an email notification
    And I can access the protocol via the secure link

  Scenario: Listen to protocol
    Given I have an assigned protocol
    When I listen to the audio
    Then my progress is tracked
    And my practitioner can see my adherence
```

### As a Practitioner (Pro User)
```gherkin
Feature: Manage patients and protocols
  As a practitioner
  I want to manage my patients and their protocols
  So that I can provide professional guidance

  Scenario: Add a new patient
    Given I am logged in as a pro user
    When I go to /pro/patients
    And I click "Nouveau patient"
    And I fill in the patient details
    Then the patient is added to my list

  Scenario: Assign protocol to patient
    Given I have a patient
    When I click "Assigner" on the patient
    And I select a program
    And I add clinical notes
    Then the protocol is assigned
    And the patient receives an email

  Scenario: Track patient progress
    Given I have assigned protocols
    When I go to /pro/protocols
    Then I see all protocols with their status
    And I can update the status and progress
```

### As Dr. Rosati (Admin)
```gherkin
Feature: Manage consultations
  As Dr. Rosati
  I want to manage patient consultations
  So that I can deliver custom protocols

  Scenario: Review consultation request
    Given a patient has booked a consultation
    When I go to /admin/consultations
    Then I see the consultation details
    And I can update the status

  Scenario: Deliver custom protocol
    Given a consultation is in progress
    When I upload the custom protocol files
    And I add protocol notes
    And I mark it as delivered
    Then the patient receives an email
    And can access their custom protocol
```
