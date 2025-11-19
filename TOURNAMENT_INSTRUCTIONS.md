# Tournament Management Instructions

## Table of Contents
1. [Overview](#overview)
2. [Creating a Tournament](#creating-a-tournament)
3. [Tournament Types](#tournament-types)
4. [Managing Tournaments](#managing-tournaments)
5. [Scoring & Leaderboards](#scoring--leaderboards)
6. [League Management](#league-management)

---

## Overview

The Smith Center Golf Course tournament system supports:
- **Individual tournaments** - Traditional stroke play
- **Team scrambles** - 1-4 player teams
- **Flight divisions** - Up to 5 flights for competitive groupings
- **Tie-breaking** - USGA or handicap hole methods
- **League play** - Weekly competitions (Men's & Women's)

---

## Creating a Tournament

### Step 1: Access Tournament Creation
1. Login as an **admin user**
2. Navigate to **Tournaments** in the main menu
3. Click **"Create Tournament"** button (only visible to admins)

### Step 2: Basic Information

#### Required Fields:

**Tournament Name**
- Examples: "Spring Classic 2025", "Labor Day Scramble", "Tuesday Men's League Week 1"
- Keep names descriptive and include the date or week number

**Description** (Optional)
- Add details about the tournament
- Include any special rules or prizes
- Example: "Annual 2-day tournament with flights. Prizes for each flight."

**Start Date & End Date**
- Single day: Same date for both
- Multi-day: Different dates (e.g., 2-Day tournament)
- Start date must be today or in the future

**Number of Holes**
- **9 holes** - For league play or shorter tournaments
- **18 holes** - For full tournaments

**Entry Fee**
- Enter amount in dollars (e.g., 25.00)
- Set to 0 for free tournaments
- For leagues, this is typically the weekly entry fee

### Step 3: Tournament Format

**Individual Play**
- Standard stroke play
- Each golfer plays their own ball
- Individual scores are tracked
- Best for: Traditional tournaments, league play

**Scramble Format**
- Team-based play
- All players hit, best shot selected
- Team size: 1-4 players
- Best for: Social tournaments, fundraisers

**Team Size** (Scramble only)
- 1 Player: Individual with scramble scoring
- 2 Player: Couples, 2-man best ball
- 3 Player: 3-man scramble
- 4 Player: Standard 4-person scramble

### Step 4: Advanced Settings

**Maximum Participants**
- Leave empty for unlimited entries
- Set a number to cap registrations
- For scrambles, this counts teams (not individual players)

**Number of Flights**
- **1 Flight**: All participants compete together
- **2-5 Flights**: Divides participants into competitive groups
- Flights are automatically assigned based on scores
- Tied participants stay in the same flight
- Best for: Large tournaments with varied skill levels

**Tie Breaking Method**

**USGA Standard (Recommended)**
1. Total score (lowest wins)
2. Last 9 holes score
3. Last 6 holes score
4. Last 3 holes score
5. Last 1 hole score
6. Handicap holes (hardest first)

**Handicap Holes Only**
1. Total score (lowest wins)
2. Handicap holes only (hardest holes first)
3. Best for: Courses with well-defined handicap rankings

### Step 5: Submit
- Click **"Create Tournament"**
- You'll be redirected to the tournament detail page
- Status will be set to **"Upcoming"**

---

## Tournament Types

### 1. One-Day Individual Tournament
```
Name: "Spring Classic 2025"
Format: Individual
Holes: 18
Dates: Same day
Flights: 2-3
Entry Fee: $25
Tie Breaking: USGA
```

### 2. Multi-Day Tournament
```
Name: "2-Day Labor Day Tournament"
Format: Individual
Holes: 18
Start: September 1, 2025
End: September 2, 2025
Flights: 3
Entry Fee: $50
```

### 3. Team Scramble
```
Name: "4-Man Scramble"
Format: Scramble
Team Size: 4
Holes: 18
Dates: Same day
Flights: 1
Entry Fee: $100 per team
```

### 4. Weekly League Play
```
Name: "Men's League - Week 5"
Format: Individual
Holes: 9
Dates: Same day (Tuesday)
Flights: 2
Entry Fee: $12
Max Participants: 40
```

---

## Managing Tournaments

### Tournament Status

**Upcoming** (Default)
- Tournament is created but not started
- Players can register
- Scores cannot be entered yet

**Active**
- Tournament is in progress
- Players can enter scores
- Leaderboard is live
- To activate: Edit tournament → Change status to "Active"

**Completed**
- Tournament is finished
- No more score entries
- Final leaderboard displayed
- To complete: Edit tournament → Change status to "Completed"

### Editing Tournaments

1. Navigate to tournament detail page
2. Click **"Edit Tournament"** (admin only)
3. Modify any fields
4. Save changes

**Note**: Be careful editing while tournament is active as it may affect scoring

### Deleting Tournaments

1. Navigate to tournament detail page
2. Click **"Delete Tournament"** (admin only)
3. Confirm deletion

**Warning**: This deletes all associated data (entries, scores, teams)

---

## Scoring & Leaderboards

### Entering Scores

**For Individual Tournaments:**
1. Players register for tournament
2. Admin assigns card numbers/groups
3. Players enter scores hole-by-hole
4. Scores automatically calculate totals

**For Team Scrambles:**
1. Captain creates team
2. Team members join
3. Captain or any team member enters team scores
4. One score per hole for the team

### Leaderboard Features

**Automatic Calculations:**
- Total score
- Score vs. Par (e.g., +5, E, -3)
- Completed holes count
- Flight assignments

**Sorting:**
- Lowest score first
- Ties broken by configured method
- Incomplete rounds shown last

**Flight Display:**
- Flights automatically assigned after scoring
- Equal distribution of participants
- Tied scores stay in same flight

### Tie Breaking in Action

**Example with USGA method:**
```
Player A: 75 total (38 on back 9)
Player B: 75 total (37 on back 9)
Winner: Player B (better back 9)
```

If still tied after back 9, system checks last 6, then 3, then 1 hole.

---

## League Management

### Setting Up Weekly Leagues

#### Men's League (Tuesday Evenings)

**Season Setup:**
Create separate tournaments for each week:

```
Week 1: "Men's League - Week 1 (May 6)"
Week 2: "Men's League - Week 2 (May 13)"
Week 3: "Men's League - Week 3 (May 20)"
... continue through August
```

**Settings per week:**
- Format: Individual
- Holes: 9
- Entry Fee: $12
- Flights: 2 (divide into A/B or High/Low)
- Max Participants: 40-50

#### Women's League (Wednesday Mornings)

```
Week 1: "Women's League - Week 1 (May 7)"
Week 2: "Women's League - Week 2 (May 14)"
... continue through August
```

**Settings per week:**
- Format: Individual or Various (scramble, best ball)
- Holes: 9
- Entry Fee: $12
- Flights: 1-2
- Max Participants: 30-40

### League Workflow

**Weekly Process:**

1. **Before League Play**
   - Create tournament for the week
   - Set status to "Active" on league day
   - Players arrive and register

2. **During Play**
   - Players keep scores on cards
   - Enter scores after completing 9 holes
   - Leaderboard updates in real-time

3. **After Play**
   - Review final leaderboard
   - Announce flight winners
   - Award weekly prizes
   - Set status to "Completed"

4. **Next Week**
   - Create new tournament for next week
   - Repeat process

### Season-Long Tracking

**Current Setup:**
- Each week is a separate tournament
- Weekly winners are tracked individually

**Future Enhancement Ideas:**
- Season points system
- Best X weeks count toward championship
- Season-end tournament combining all scores

---

## Best Practices

### Tournament Planning

1. **Create Early**: Set up tournaments at least 1 week in advance
2. **Test Setup**: Create a test tournament first to familiarize yourself
3. **Communicate**: Share tournament details with participants
4. **Set Deadlines**: Registration cutoffs before tournament day

### During Tournament

1. **Activate Timely**: Change status to "Active" on tournament day
2. **Monitor Scores**: Check for entry issues or missing scores
3. **Support Players**: Help with score entry if needed

### After Tournament

1. **Verify Scores**: Review leaderboard for accuracy
2. **Mark Complete**: Change status to "Completed" promptly
3. **Announce Results**: Share leaderboard with participants
4. **Archive**: Keep completed tournaments for records

### League Management

1. **Consistent Naming**: Use clear naming convention (League - Week X)
2. **Regular Schedule**: Same day/time each week
3. **Track Participation**: Note attendance patterns
4. **Season Planning**: Schedule all weeks at season start
5. **Prize Structure**: Decide weekly vs. season prizes

---

## Troubleshooting

### Common Issues

**Can't Create Tournament**
- Verify you're logged in as admin
- Check User model `isAdmin()` method returns true

**Team Size Not Showing**
- Only appears when "Scramble" format selected
- JavaScript toggles visibility

**Players Can't Register**
- Check tournament status (should be "Upcoming" or "Active")
- Verify max participants not reached
- Ensure player is logged in

**Scores Not Calculating**
- Verify all holes have par values set
- Check that scores are entered correctly
- Ensure tournament is "Active"

**Flight Assignment Issues**
- Flights only assigned after scores entered
- Tied players stay together
- Recalculates when new scores added

---

## Future Enhancements

### Planned Features
- Handicap tracking and calculations
- Net score tournaments
- Season points system for leagues
- Team standings page
- Automated prize calculations
- Email notifications for registrations
- Mobile-optimized scorecard entry
- Live scoring updates

### Under Consideration
- Multiple course support
- Course setup (par, handicap per hole)
- Tee time management
- Payment integration
- Tournament history statistics
- Player profiles with stats

---

## Admin Quick Reference

### Creating Standard Tournament
1. Tournaments → Create Tournament
2. Fill name, dates, holes, entry fee
3. Select format (individual or scramble)
4. Set flights (1-5)
5. Choose tie breaking method
6. Submit

### Starting Tournament
1. Open tournament detail page
2. Edit → Change status to "Active"
3. Save

### Completing Tournament
1. Verify all scores entered
2. Edit → Change status to "Completed"
3. Save
4. Share final leaderboard

### Weekly League Setup
1. Create tournament: "Men's/Women's League - Week X"
2. Format: Individual, 9 holes
3. Entry fee: $12
4. Flights: 2
5. Tie breaking: USGA
6. Activate on league day

---

## Questions or Issues?

Contact the site administrator or developer for:
- Technical issues with the system
- Feature requests
- Custom tournament formats
- Scoring problems

Remember to keep regular backups of tournament data, especially during active tournaments!
