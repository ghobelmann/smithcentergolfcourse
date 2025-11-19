<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #059669;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .details {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #059669;
        }
        .detail-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #059669;
        }
        .footer {
            background-color: #1f2937;
            color: #9ca3af;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            border-radius: 0 0 8px 8px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #059669;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Tournament Registration Confirmed!</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        
        <p>Thank you for registering for <strong>{{ $tournament->name }}</strong>. We're excited to have you join us!</p>
        
        <div class="details">
            <div class="detail-row">
                <span class="label">Tournament:</span> {{ $tournament->name }}
            </div>
            <div class="detail-row">
                <span class="label">Date:</span> {{ \Carbon\Carbon::parse($tournament->start_date)->format('l, F j, Y') }}
            </div>
            @if($tournament->tee_time)
            <div class="detail-row">
                <span class="label">Tee Time:</span> {{ \Carbon\Carbon::parse($tournament->tee_time)->format('g:i A') }}
            </div>
            @endif
            <div class="detail-row">
                <span class="label">Format:</span> {{ ucfirst($tournament->format) }}
            </div>
            @if($tournament->entry_fee > 0)
            <div class="detail-row">
                <span class="label">Entry Fee:</span> ${{ number_format($tournament->entry_fee, 2) }}
            </div>
            @endif
        </div>
        
        <p><strong>What to bring:</strong></p>
        <ul>
            <li>Your golf clubs and equipment</li>
            <li>Proper golf attire</li>
            <li>Water and snacks</li>
            <li>A positive attitude and ready to have fun!</li>
        </ul>
        
        <center>
            <a href="{{ url('/tournaments/' . $tournament->id) }}" class="button">View Tournament Details</a>
        </center>
        
        <p>If you have any questions or need to make changes to your registration, please contact us at:</p>
        <p><strong>Phone:</strong> (785) 282-3812<br>
        <strong>Email:</strong> smithcentergolfcourse@gmail.com</p>
        
        <p>See you on the course!<br>
        <strong>Smith Center Golf Course Team</strong></p>
    </div>
    
    <div class="footer">
        <p>Smith Center Golf Course<br>
        20082 US-281, Smith Center, KS 66967<br>
        (785) 282-3812 | smithcentergolfcourse@gmail.com</p>
    </div>
</body>
</html>
