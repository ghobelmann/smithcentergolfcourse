<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
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
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #059669;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            min-height: 100px;
            white-space: pre-wrap;
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
        <h1>📧 New Contact Form Submission</h1>
    </div>
    
    <div class="content">
        <p><strong>A new message has been received from the Smith Center Golf Course website contact form.</strong></p>
        
        <div class="field">
            <span class="label">From:</span>
            <div class="value">{{ $name }} ({{ $email }})</div>
        </div>

        @if(isset($phone) && $phone)
        <div class="field">
            <span class="label">Phone:</span>
            <div class="value">{{ $phone }}</div>
        </div>
        @endif

        <div class="field">
            <span class="label">Subject:</span>
            <div class="value">{{ $subject }}</div>
        </div>

        <div class="field">
            <span class="label">Message:</span>
            <div class="message-box">{{ $contactMessage }}</div>
        </div>

        <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <strong>To reply:</strong> Simply reply to this email or contact {{ $name }} at {{ $email }}
            @if(isset($phone) && $phone)
            or {{ $phone }}
            @endif
        </p>
    </div>
    
    <div class="footer">
        <p>This message was sent from the Smith Center Golf Course website contact form<br>
        Received: {{ date('F j, Y g:i A') }}</p>
    </div>
</body>
</html>
