# Golf Tournament System - Test Documentation

## Overview
This document describes the comprehensive test suite for the Golf Tournament Management System. The tests cover the complete workflow from tournament creation to mobile scoring and leaderboard management.

## Test Structure

### 1. Model Factories
Located in `database/factories/`, these factories create realistic test data:

- **UserFactory**: Creates users with golf-specific attributes (handicap, home course, admin status)
- **TournamentFactory**: Creates tournaments with various formats (individual, scramble)
- **CourseFactory**: Creates golf courses with holes and tees
- **CourseHoleFactory**: Creates individual holes with par and handicap
- **CourseTeeFactory**: Creates tee boxes with ratings and slopes
- **CourseHoleTeeYardageFactory**: Creates yardage information for each hole/tee combination
- **TeamFactory**: Creates teams with members for scramble tournaments
- **TournamentEntryFactory**: Creates individual tournament registrations
- **ScoreFactory**: Creates golf scores with various results (birdie, eagle, par, bogey)

### 2. Feature Tests

#### TournamentManagementTest.php
Tests tournament CRUD operations and admin permissions:
- ✅ Admin can view tournaments index
- ✅ Regular users cannot access tournament management
- ✅ Admin can create individual tournaments
- ✅ Admin can create scramble tournaments
- ✅ Tournament validation works correctly
- ✅ Admin can update and delete tournaments
- ✅ Tournament format determines valid team size
- ✅ Guest access is properly restricted

#### CourseManagementTest.php
Tests golf course setup and management:
- ✅ Admin can create courses with full details
- ✅ Course validation works correctly
- ✅ Admin can setup courses with holes and tees
- ✅ Course setup creates holes based on hole count
- ✅ Tee validation prevents invalid ratings/slopes
- ✅ Course deletion cascades properly
- ✅ Holes are created with realistic default values

#### TeamRegistrationTest.php
Tests team formation and tournament registration:
- ✅ Users can register for individual tournaments
- ✅ Users can create teams for scramble tournaments
- ✅ Team captains are automatically added as members
- ✅ Captains can add/remove team members
- ✅ Teams cannot exceed tournament team size
- ✅ Users cannot join multiple teams in same tournament
- ✅ Only team captains can manage members
- ✅ Team names must be unique within tournament

#### MobileScoringTest.php
Tests mobile scoring interface and QR code functionality:
- ✅ Players can access mobile scoring via QR codes
- ✅ Team captains can access team scoring
- ✅ Invalid QR tokens are rejected
- ✅ Players can enter and update scores
- ✅ Score validation works correctly
- ✅ Mobile interface displays current scores and totals
- ✅ Players can add notes to scores
- ✅ Mobile interface shows hole information and yardages
- ✅ Completed tournaments are read-only

#### LeaderboardTest.php
Tests leaderboard display and calculations:
- ✅ Individual leaderboards display correctly ordered by score
- ✅ Team leaderboards show team rankings
- ✅ Score calculations are accurate (strokes, par, totals)
- ✅ Incomplete rounds are handled properly
- ✅ Live leaderboard updates work
- ✅ Current hole being played is shown
- ✅ Tournament privacy settings are respected
- ✅ Ties are displayed correctly
- ✅ Results are cached for performance

#### CardAssignmentTest.php
Tests starting hole and group assignment:
- ✅ Admin can view card assignment page
- ✅ Admin can assign starting holes and groups
- ✅ Card assignment validation prevents errors
- ✅ Duplicate positions are prevented
- ✅ Auto-assignment distributes players evenly
- ✅ Scorecards can be printed with QR codes
- ✅ Different tournament formats are handled
- ✅ Shotgun starts are supported
- ✅ Assignment clearing works properly

#### TournamentIntegrationTest.php
Tests complete end-to-end workflows:
- ✅ **Complete Individual Tournament Workflow**:
  1. Admin creates course with holes and tees
  2. Admin creates tournament
  3. Players register for tournament
  4. Admin assigns cards and starting positions
  5. Admin prints scorecards with QR codes
  6. Players enter scores via mobile QR scanning
  7. Live leaderboard updates during play
  8. Players complete full rounds
  9. Admin marks tournament as completed
  10. Final results are accurate

- ✅ **Complete Scramble Tournament Workflow**:
  1. Admin creates scramble tournament
  2. Player creates team and adds members
  3. Admin assigns team cards
  4. Team plays using mobile scoring
  5. Team leaderboard displays correctly
  6. Team scores are saved properly

- ✅ **Error Handling**:
  - Duplicate registrations are prevented
  - Invalid QR tokens return 404
  - Invalid hole numbers are rejected
  - Unauthorized access is blocked

- ✅ **Statistics and Reporting**:
  - Tournament statistics show completion status
  - Leaderboard shows different completion levels
  - Progress tracking works correctly

## Test Data Scenarios

### User Types
- **Admin User**: Full access to all management functions
- **Regular Players**: Can register, play, and view public tournaments
- **Team Captains**: Can create and manage teams

### Tournament Formats
- **Individual**: Single players competing against each other
- **Scramble**: Teams of 2-4 players using best ball format

### Course Configurations
- **18-hole courses**: Full championship layouts
- **9-hole courses**: Shorter executive courses
- **Multiple tees**: Championship, Blue, White, Red tees with different ratings

### Scoring Scenarios
- **Complete rounds**: All 18 holes played
- **Incomplete rounds**: Partial completion tracking
- **Various scores**: Eagles, birdies, pars, bogeys, and worse
- **Team scores**: Best ball scramble scoring

## Running the Tests

### Quick Test Run
```bash
# Run all golf tournament tests
./vendor/bin/phpunit --configuration=phpunit-golf.xml --testsuite="Golf Tournament System"
```

### Individual Test Suites
```bash
# Tournament management
./vendor/bin/phpunit tests/Feature/TournamentManagementTest.php

# Course management
./vendor/bin/phpunit tests/Feature/CourseManagementTest.php

# Team registration
./vendor/bin/phpunit tests/Feature/TeamRegistrationTest.php

# Mobile scoring
./vendor/bin/phpunit tests/Feature/MobileScoringTest.php

# Leaderboards
./vendor/bin/phpunit tests/Feature/LeaderboardTest.php

# Card assignment
./vendor/bin/phpunit tests/Feature/CardAssignmentTest.php

# Integration tests
./vendor/bin/phpunit tests/Feature/TournamentIntegrationTest.php
```

### Using the Test Runner Script
```bash
# Run comprehensive test suite with detailed output
./run-golf-tests.sh
```

## Test Environment Configuration

### Database
- Uses SQLite in-memory database for fast, isolated testing
- Fresh database migration for each test
- RefreshDatabase trait ensures clean state

### Authentication
- Factory-created users with realistic golf attributes
- Admin and regular user permission testing
- Guest access restriction validation

### Caching
- Array cache driver for consistent test results
- Cache invalidation testing for leaderboards

## Coverage Goals

The test suite aims for high coverage of:
- ✅ **Controllers**: All tournament, course, team, and scoring endpoints
- ✅ **Models**: All relationships and helper methods
- ✅ **Policies**: Admin and user authorization rules
- ✅ **Validation**: All form and API input validation
- ✅ **Business Logic**: Tournament rules, scoring calculations, leaderboard rankings

## Performance Considerations

- Tests use factories instead of seeders for faster execution
- Database transactions isolate test data
- Minimal HTTP requests in integration tests
- Realistic but not excessive test data volumes

## Future Test Enhancements

Potential additions to the test suite:
- [ ] Browser tests using Laravel Dusk for full UI testing
- [ ] API endpoint tests for mobile app integration
- [ ] Performance tests for large tournaments (100+ players)
- [ ] Email notification testing for tournament updates
- [ ] Payment processing tests for entry fees
- [ ] Weather integration tests for tournament delays
- [ ] Handicap calculation verification tests

## Test Maintenance

- Update factories when database schema changes
- Add tests for new features before implementation
- Keep test data realistic and representative
- Monitor test execution time and optimize as needed
- Regularly review coverage reports for gaps