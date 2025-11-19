<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Reminder</title>
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
            background-color: #2563eb;
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
        .reminder-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .details {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .detail-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #2563eb;
        }
        .footer {
            background-color: #1f2937;
            color: #9ca3af;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>⛳ Tournament Reminder</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        
        <div class="reminder-box">
            <h2 style="margin-top: 0;">Don't forget - your tournament is tomorrow!</h2>
            <p style="margin-bottom: 0;">{{ $tournament->name }}</p>
        </div>
        
        <div class="details">
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
        </div>
        
        <p><strong>Remember to arrive at least 15 minutes early to:</strong></p>
        <ul>
            <li>Check in at the clubhouse</li>
            <li>Warm up on the practice range</li>
            <li>Meet your playing partners</li>
        </ul>
        
        <p><strong>Weather Forecast:</strong> Please check the weather before you come. If there are any changes or cancellations, we will notify you immediately.</p>
        
        <p>We're looking forward to seeing you on the course!</p>
        
        <p><strong>Questions?</strong> Contact us at:<br>
        Phone: (785) 282-3812<br>
        Email: smithcentergolfcourse@gmail.com</p>
        
        <p>Good luck and have a great round!<br>
        <strong>Smith Center Golf Course Team</strong></p>
    </div>
    
    <div class="footer">
        <p>Smith Center Golf Course<br>
        20082 US-281, Smith Center, KS 66967<br>
        (785) 282-3812 | smithcentergolfcourse@gmail.com</p>
    </div>
</body>
</html>
