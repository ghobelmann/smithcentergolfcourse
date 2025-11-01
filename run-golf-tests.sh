#!/bin/bash

# Golf Tournament System Test Runner
# This script runs the complete test suite for the golf tournament management system

echo "🏌️ Golf Tournament System Test Suite"
echo "====================================="
echo ""

# Check if vendor directory exists
if [ ! -d "vendor" ]; then
    echo "❌ Vendor directory not found. Please run 'composer install' first."
    exit 1
fi

# Check if .env.testing exists, create if not
if [ ! -f ".env.testing" ]; then
    echo "📄 Creating .env.testing file..."
    cp .env.example .env.testing
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env.testing
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=:memory:/' .env.testing
    echo "APP_KEY=" >> .env.testing
    php artisan key:generate --env=testing
fi

echo "🧪 Running Golf Tournament System Tests..."
echo ""

# Run specific test suites with detailed output
echo "1️⃣ Tournament Management Tests"
./vendor/bin/phpunit tests/Feature/TournamentManagementTest.php --colors=always

echo ""
echo "2️⃣ Course Management Tests"
./vendor/bin/phpunit tests/Feature/CourseManagementTest.php --colors=always

echo ""
echo "3️⃣ Team Registration Tests"
./vendor/bin/phpunit tests/Feature/TeamRegistrationTest.php --colors=always

echo ""
echo "4️⃣ Mobile Scoring Tests"
./vendor/bin/phpunit tests/Feature/MobileScoringTest.php --colors=always

echo ""
echo "5️⃣ Leaderboard Tests"
./vendor/bin/phpunit tests/Feature/LeaderboardTest.php --colors=always

echo ""
echo "6️⃣ Card Assignment Tests"
./vendor/bin/phpunit tests/Feature/CardAssignmentTest.php --colors=always

echo ""
echo "7️⃣ Integration Tests"
./vendor/bin/phpunit tests/Feature/TournamentIntegrationTest.php --colors=always

echo ""
echo "🏁 Complete Test Suite"
./vendor/bin/phpunit --configuration=phpunit-golf.xml --testsuite="Golf Tournament System" --colors=always

echo ""
echo "✅ Golf Tournament System Test Suite Complete!"
echo ""

# Optional: Generate coverage report
read -p "📊 Generate code coverage report? (y/n): " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "📈 Generating coverage report..."
    ./vendor/bin/phpunit --configuration=phpunit-golf.xml --testsuite="Golf Tournament System" --coverage-html coverage/
    echo "📄 Coverage report generated in coverage/index.html"
fi