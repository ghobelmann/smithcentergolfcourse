# Four-Ball Match Play Scoring System

## Overview
The league uses **Four-Ball Best Ball Match Play** format where each hole is worth 1 point, and teams compete hole-by-hole rather than on total strokes.

---

## Core Scoring Rules

### Four-Ball Format
- **Both players** on each team play their own ball throughout the round
- **Team score** for each hole = the better (lower) score of the two partners
- Only one partner needs to finish the hole for the team to have a score
- Partners can play in any order they choose

### Match Play Scoring
- **Each hole is worth 1 point**
- **9 holes = 9 points maximum** per week
- The team with the lowest score on a hole **wins that hole** (earns 1 point)
- If teams tie on a hole, the hole is **halved** (each team gets 0.5 points)

### Weekly Points Example

**Week 3 - Team A vs All Other Teams:**

| Hole | Team A | Team B | Team C | Team D | Result |
|------|--------|--------|--------|--------|--------|
| 1 | 4 | 5 | 4 | 6 | Team A: 0.5, Team C: 0.5 (tied best) |
| 2 | 3 | 4 | 5 | 4 | Team A: 1.0 (best score) |
| 3 | 5 | 4 | 6 | 5 | Team B: 1.0 (best score) |
| 4 | 4 | 4 | 4 | 5 | Team A: 0.33, Team B: 0.33, Team C: 0.33 |
| ... | ... | ... | ... | ... | ... |

**After 9 holes**, each team's points are totaled for the week.

---

## Season Standings

### Cumulative Points
- Each week's points are added to the season total
- Example: Player with 6.5 points in Week 1, 7.0 in Week 2 = **13.5 total points**

### Ranking
Teams/players are ranked by:
1. **Total season points** (highest first)
2. **Tiebreaker**: Lowest total strokes across all weeks
3. **Second tiebreaker**: Most weeks played

### Championship Qualification
If league is set to count "Best X Weeks":
- Only the player's best scoring weeks count
- Example: Best 8 of 12 weeks = top 8 weekly scores summed
- Encourages consistent play throughout the season

---

## Handicaps

When handicaps are used:
- Applied to each player's **gross score** before determining team's best ball
- Team's best ball is calculated **after** handicap adjustments
- Example:
  - Player A: 5 strokes, Handicap 2 = **Net 3**
  - Player B: 4 strokes, Handicap 0 = **Net 4**
  - Team's best ball for that hole = **3** (Player A's net score)

---

## How Scoring Works in the System

### 1. Tournament Completion
When a tournament is marked as complete, admin clicks "Calculate Standings"

### 2. Best Ball Calculation
For each team:
- System retrieves hole-by-hole scores for both players
- For each hole, takes the **lower score** (best ball)
- Creates a 9-hole best ball scorecard per team

### 3. Hole-by-Hole Comparison
- Each team's best ball is compared against every other team
- For Hole 1: Lowest score(s) win that hole
- Points distributed: 1 point for winner, 0.5 each for ties

### 4. Weekly Points Total
- Sum of all holes won/halved for the week
- Maximum: 9 points (winning all 9 holes against all teams)
- Realistic range: 3-7 points depending on field size

### 5. Season Update
- Weekly points added to player's season total
- Cumulative statistics updated (weeks played, best score, etc.)
- Standings recalculated

---

## Advantages of Match Play Format

### Fair Competition
- **Eliminates blowout losses**: One bad hole doesn't ruin your week
- **More exciting**: Every hole matters equally
- **Comeback friendly**: Down by 2 holes? Still 7 holes to play!

### Strategy Elements
- **Risk/reward decisions** on each hole
- **Team coordination**: Which partner takes risks, which plays safe
- **Concessions**: Can concede short putts to speed up play

### Season-Long Engagement
- **Consistent scoring**: 9 points available every week
- **Clear goals**: Win 5+ holes per week to stay competitive
- **Easy to understand**: "We won 6 holes today" vs complex stroke totals

---

## Example Season Scenario

### Men's League 2025 (12 weeks)

**Player: John Smith**

| Week | Holes Won | Points | Cumulative |
|------|-----------|--------|------------|
| 1 | 5.5 | 5.5 | 5.5 |
| 2 | 7.0 | 7.0 | 12.5 |
| 3 | 4.5 | 4.5 | 17.0 |
| 4 | 6.0 | 6.0 | 23.0 |
| 5 | 5.0 | 5.0 | 28.0 |
| ... | ... | ... | ... |
| 12 | 6.5 | 6.5 | 68.5 |

**Championship Qualification (Best 8 of 12):**
- Takes 8 highest weekly scores
- Sum = Championship Points
- Highest championship points wins season

---

## Admin Workflow

### Setting Up League
1. Create league with Match Play scoring selected
2. Set season dates (e.g., May-August, 12 weeks)
3. Generate weekly tournaments automatically
4. Members enroll and pair into 2-man teams

### Weekly Management
1. Members play their round on league day
2. Enter scores hole-by-hole in tournament
3. Admin clicks "Calculate Week Standings"
4. System automatically:
   - Calculates best ball for each team
   - Compares hole-by-hole against all teams
   - Awards points for holes won/halved
   - Updates season standings

### Season End
1. Review cumulative standings
2. If using "Best X Weeks", check championship standings
3. Award prizes/trophies
4. Archive league as "Completed"

---

## Technical Implementation

### Database
- **league_standings** table tracks weekly and cumulative stats
- `points_earned` = holes won that week (0-9 scale)
- `total_points` = cumulative for entire season
- `total_score` = total strokes (for tiebreakers)

### Calculation Engine
- `MatchPlayScoringService` class handles all logic
- Hole-by-hole best ball extraction
- Multi-team comparison algorithm
- Automatic position ranking

### API
- `POST /admin/leagues/{league}/calculate/{tournament}` triggers calculation
- Returns results and updates standings
- Error handling for incomplete scores

---

## Member Experience

### Joining League
1. Browse active leagues at `/leagues-system`
2. Click "Join League"
3. Enter handicap (optional)
4. System pairs with another player for team

### Weekly Play
1. Show up on league day
2. Play 9 holes with team partner
3. Enter scores hole-by-hole
4. View results after admin calculates standings

### Tracking Progress
- View season standings anytime
- See personal stats: points, weeks played, best scores
- Check championship qualification status
- Compare with other teams

---

## FAQs

**Q: What if my partner can't play one week?**
A: You can find a substitute, or sit out that week. Missing weeks doesn't hurt your season average.

**Q: How many points do I need to win?**
A: In a 12-week season with 4 teams, consistently winning 5-6 holes per week puts you in contention. Total around 65-75 points should compete for the championship.

**Q: Do we play against all teams every week?**
A: Yes, your best ball scorecard is compared against all other teams hole-by-hole. More teams = more comparisons.

**Q: Can we tie for season champion?**
A: Tiebreaker is lowest total strokes across all weeks. If still tied, most weeks played wins.

**Q: What happens if we only complete 7 holes?**
A: You only earn points for holes completed. The other 2 holes award no points (0 points).

---

Last Updated: November 19, 2025
