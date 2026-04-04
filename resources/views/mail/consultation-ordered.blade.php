<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nouvelle Consultation</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
    .wrap { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.1); }
    .header { background: #0d7377; padding: 28px 32px; }
    .header h1 { color: #ffffff; font-size: 22px; margin: 0; }
    .header p { color: rgba(255,255,255,.75); margin: 6px 0 0; font-size: 13px; }
    .body { padding: 28px 32px; }
    .section-title { font-size: 11px; text-transform: uppercase; letter-spacing: .1em; color: #0d7377; margin-bottom: 10px; font-weight: 700; }
    .field { margin-bottom: 16px; }
    .field label { display: block; font-size: 12px; color: #888; margin-bottom: 3px; }
    .field span { font-size: 15px; color: #1a1a1a; font-weight: 500; }
    .badge { display: inline-block; background: #fff3cd; color: #856404; border: 1px solid #ffc107; border-radius: 20px; padding: 3px 14px; font-size: 12px; font-weight: 600; }
    .symptoms-box { background: #f8f9fa; border-left: 3px solid #0d7377; border-radius: 4px; padding: 12px 16px; font-size: 14px; color: #333; line-height: 1.6; white-space: pre-wrap; }
    .footer { background: #f4f4f4; padding: 16px 32px; font-size: 12px; color: #aaa; border-top: 1px solid #eee; }
    .btn { display: inline-block; background: #0d7377; color: #fff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; margin-top: 20px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <h1>🩺 Nouvelle consultation reçue</h1>
      <p>Commande {{ $order->order_number }} · Paiement confirmé</p>
    </div>
    <div class="body">

      <p class="section-title">Informations client</p>
      <div class="field"><label>Nom</label><span>{{ $consultation->name }}</span></div>
      <div class="field"><label>Email</label><span>{{ $consultation->email }}</span></div>
      @if($consultation->phone)
      <div class="field"><label>Téléphone</label><span>{{ $consultation->phone }}</span></div>
      @endif

      <hr style="border:none;border-top:1px solid #eee;margin:20px 0">

      <p class="section-title">Détails de la consultation</p>
      <div class="field">
        <label>Formule</label>
        <span>
          @if($consultation->package_type === 'single') Essentiel (1 séance)
          @elseif($consultation->package_type === 'progress') Évolution (3 séances)
          @else Transformation (5 séances)
          @endif
        </span>
      </div>
      <div class="field"><label>Montant payé</label><span>€{{ number_format($consultation->amount, 2) }}</span></div>
      <div class="field"><label>Statut</label><span class="badge">En attente</span></div>

      <hr style="border:none;border-top:1px solid #eee;margin:20px 0">

      <p class="section-title">Symptômes & Objectifs</p>
      <div class="symptoms-box">{{ $consultation->symptoms ?: 'Non renseigné' }}</div>

      @if($consultation->medical_history)
      <div style="margin-top:16px">
        <p class="section-title">Antécédents médicaux</p>
        <div class="symptoms-box">{{ $consultation->medical_history }}</div>
      </div>
      @endif

      <a href="{{ url('/admin/consultations') }}" class="btn">Gérer dans l'admin →</a>
    </div>
    <div class="footer">
      Vitality Inside · Notification automatique — Ne pas répondre à cet email.
    </div>
  </div>
</body>
</html>
