<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Enrollment Confirmation</title>
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
        <h1>Welcome to the League!</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        
        <p>Congratulations! You've successfully enrolled in <strong>{{ $league->name }}</strong>. We're thrilled to have you as part of our league community!</p>
        
        <div class="details">
            <div class="detail-row">
                <span class="label">League:</span> {{ $league->name }}
            </div>
            <div class="detail-row">
                <span class="label">Type:</span> {{ ucfirst($league->type) }}
            </div>
            <div class="detail-row">
                <span class="label">Season:</span> {{ \Carbon\Carbon::parse($league->season_start)->format('F j') }} - {{ \Carbon\Carbon::parse($league->season_end)->format('F j, Y') }}
            </div>
            <div class="detail-row">
                <span class="label">Schedule:</span> {{ $league->schedule }}
            </div>
            @if($league->registration_fee > 0)
            <div class="detail-row">
                <span class="label">Registration Fee:</span> ${{ number_format($league->registration_fee, 2) }}
            </div>
            @endif
        </div>
        
        <p><strong>What happens next:</strong></p>
        <ul>
            <li>Weekly tournaments will be scheduled according to the league schedule</li>
            <li>You'll receive reminders before each week's tournament</li>
            <li>Standings will be updated after each week of play</li>
            <li>Check the website regularly for updates and announcements</li>
        </ul>
        
        <center>
            <a href="{{ url('/leagues-system/' . $league->id) }}" class="button">View League Details</a>
        </center>
        
        <p><strong>League Resources:</strong></p>
        <ul>
            <li><a href="{{ url('/leagues-system/' . $league->id . '/roster') }}">View Roster</a></li>
            <li><a href="{{ url('/leagues-system/' . $league->id . '/standings') }}">Current Standings</a></li>
            <li><a href="{{ url('/leagues-system/' . $league->id . '/weekly') }}">Weekly Results</a></li>
        </ul>
        
        <p>If you have any questions about the league, please don't hesitate to reach out:</p>
        <p><strong>Phone:</strong> (785) 282-3812<br>
        <strong>Email:</strong> smithcentergolfcourse@gmail.com</p>
        
        <p>We look forward to a great season of golf!<br>
        <strong>Smith Center Golf Course Team</strong></p>
    </div>
    
    <div class="footer">
        <p>Smith Center Golf Course<br>
        20082 US-281, Smith Center, KS 66967<br>
        (785) 282-3812 | smithcentergolfcourse@gmail.com</p>
    </div>
</body>
</html>
