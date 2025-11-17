# Google OAuth Setup Instructions

## Step 1: Create a Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API (or Google Identity API)

## Step 2: Create OAuth 2.0 Credentials

1. Go to **APIs & Services** > **Credentials**
2. Click **Create Credentials** > **OAuth client ID**
3. Select **Web application**
4. Add these to **Authorized redirect URIs**:
   - `http://localhost:8000/auth/google/callback` (for local development)
   - `http://127.0.0.1:8000/auth/google/callback` (for local development)
   - `https://yourdomain.com/auth/google/callback` (for production)

5. Click **Create**
6. Copy the **Client ID** and **Client Secret**

## Step 3: Add to .env File

Add these lines to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

For production, update the redirect URI:
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

## Step 4: Test the Integration

1. Start your development server: `php artisan serve`
2. Go to the login page: `http://localhost:8000/login`
3. Click **Continue with Google**
4. You should be redirected to Google for authentication
5. After authorizing, you'll be redirected back and logged in

## Features

- **Easy Registration**: Users can sign up with one click using their Google account
- **No Password Required**: Google handles authentication
- **Auto Email Verification**: Users authenticated via Google are automatically verified
- **Seamless Login**: Quick login for tournament registration
- **Profile Picture**: User's Google avatar is saved for display

## Security Notes

- Keep your `GOOGLE_CLIENT_SECRET` secure and never commit it to version control
- The `.env` file is already in `.gitignore`
- Users created via Google get a random secure password (they won't need it)
- Existing users can link their Google account by logging in with their email first

## Tournament Registration Flow

1. User visits tournament page
2. Clicks "Register for Tournament"
3. If not logged in, redirected to login page
4. User clicks "Continue with Google"
5. Google authentication happens
6. User is automatically logged in and redirected back to tournament registration
7. Tournament registration form is pre-filled with their Google profile info

This makes tournament registration super fast and easy! 🏌️‍♂️
