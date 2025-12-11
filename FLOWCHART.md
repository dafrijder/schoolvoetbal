 # Schoolvoetbal — Algemene flowchart

 Eén compact overzicht van de hoofdlijnen van de applicatie: client → routes → middleware → controllers → modellen/views/API → client.

 ```mermaid
 flowchart LR
    A[Browser / User] --> B[Routes (routes/web.php)]
    B --> C{Middleware}
    C -->|guest| Auth[AuthController]
    C -->|auth| Teams[TeamController]
    C -->|auth| Games[GameController]
    C -->|auth + admin| Admin[AdminController]
    B --> API[ApiController]

    Teams --> DB[(Database)]
    Games --> DB
    Auth --> DB
    API --> DB

    Teams --> Views[Blade Views]
    Games --> Views
    Auth --> Views

    Views --> A
    API --> A

    DB --> Tables[Users, Teams, Games, Goals]

    style A fill:#fef3c7,stroke:#b45309
    style B fill:#f0f9ff,stroke:#0369a1
    style C fill:#eef2ff,stroke:#4338ca
    style Teams fill:#ecfccb,stroke:#65a30d
    style Games fill:#ecfccb,stroke:#65a30d
    style Auth fill:#ecfccb,stroke:#65a30d
    style API fill:#ede9fe,stroke:#7c3aed
    style Views fill:#fff7ed,stroke:#c2410c
    style DB fill:#ffffff,stroke:#374151
 ```

 Kort:

- Client: gebruiker in de browser.
- Routes: `routes/web.php` bepaalt welke controller reageert.
- Middleware: `auth`, `admin` e.d. bepalen toegangspaden.
- Controllers: verwerken requests, valideren en communiceren met DB of renderen views.
- Database: hoofdtabellen `users`, `teams`, `games`, `goals`.
- Views/API: Blade voor HTML; `ApiController` voor JSON.

Wil je dat ik deze Mermaid-diagram exporteer naar PNG/SVG of een eenvoudige PDF-visualisatie maak?

## 🏢 Teams Management Flow

```
Dashboard/Home
  │
  └─► Teams Module
      │
      ├──► GET /teams ──► TeamController::index
      │    (Display all teams)
      │    │
      │    └──► View: teams/index.blade.php
      │        └─ Shows: List of teams with Edit/Delete actions
      │
      ├──► GET /teams/create ──► TeamController::create
      │    (Show team creation form)
      │    │
      │    └──► View: teams/create.blade.php
      │
      ├──► POST /teams ──► TeamController::store
      │    (Save new team to database)
      │    │
      │    ├─ Validate input
      │    ├─ Create Team record (with creator_id)
      │    └─ Redirect to teams.index
      │
      ├──► GET /teams/{team} ──► TeamController::show
      │    (Display team details)
      │    │
      │    ├─ Load Team with:
      │    │  ├─ Players (users)
      │    │  ├─ Games
      │    │  └─ Creator info
      │    │
      │    └──► View: teams/show.blade.php
      │
      ├──► GET /teams/{team}/edit ──► TeamController::edit
      │    (Show team edit form)
      │    │
      │    └──► View: teams/edit.blade.php
      │
      ├──► PUT /teams/{team} ──► TeamController::update
      │    (Update team data)
      │    │
      │    ├─ Validate input
      │    ├─ Update Team record
      │    └─ Redirect to teams.show
      │
      └──► DELETE /teams/{team} ──► TeamController::destroy
           (Delete team)
           │
           ├─ Confirm deletion
           ├─ Remove Team record
           └─ Redirect to teams.index
```

## 🎮 Games Management Flow

```
Games Module
  │
  ├──► Create Game
  │    │
  │    ├─ Select Team1
  │    ├─ Select Team2
  │    ├─ Set Score (team1_score, team2_score)
  │    ├─ Select Field
  │    ├─ Select Referee (User)
  │    ├─ Set Time
  │    │
  │    └──► POST /games ──► GameController::store
  │        (Save Game to database)
  │
  ├──► View Games
  │    └──► GET /api/games ──► ApiController::getGames
  │        (Return JSON list of games)
  │
  └──► Goals Management
       │
       └──► Add Goal to Game
           ├─ Select Player
           ├─ Set Minute
           ├─ Associate with Game
           │
           └──► POST /goals ──► GoalController::store
               (Save Goal to database)
```

## 👥 Users & Roles Flow

```
User System
  │
  ├──► Regular User
  │    ├─ Can register/login
  │    ├─ Can join a Team
  │    ├─ Can play in Games
  │    └─ Can score Goals
  │
  └──► Admin User
       ├─ All user permissions
       ├─ Access Admin Panel (GET /admin)
       ├─ Manage Teams
       ├─ Manage Games
       ├─ Manage Users
       │
       └──► AdminController::index
           (Admin dashboard)
```

## 🗄️ Database Models & Relationships

```
┌─────────────────┐
│      USER       │
├─────────────────┤
│ id (PK)         │
│ name            │
│ email           │
│ password        │
│ team_id (FK)    │
│ is_admin        │
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │
         ├─────────────────────────────┐
         │                             │
    ┌────▼──────────────┐    ┌────────▼────────┐
    │ Belongs to TEAM   │    │ Creates TEAMS   │
    │ (Player)          │    │ (creator_id)    │
    └───────────────────┘    └─────────────────┘
                                     ▲
                                     │
         ┌─────────────────────────────────────────────┐
         │                                             │
         │                                             │
    ┌────┴──────────────────────────────────────────┐ │
    │              TEAM                             │ │
    ├────────────────────────────────────────────────┤ │
    │ id (PK)                                       │ │
    │ name                                          │ │
    │ points                                        │ │
    │ creator_id (FK) ───────────────────────────────┘ │
    │ created_at                                    │ │
    │ updated_at                                    │ │
    └────┬────────────────────┬──────────────────────┘ │
         │                    │                        │
         │                    │                        │
    ┌────▼──────┐    ┌────────▼──────────┐    ┌──────┴─────┐
    │ hasMany    │    │ hasMany GamesAs   │    │ belongsTo  │
    │ USERS      │    │ Team1/Team2       │    │ USER       │
    │ (Players)  │    │                   │    │            │
    └────────────┘    └─────┬─────────────┘    └────────────┘
                            │
                            │
                    ┌───────┴───────┐
                    │               │
              ┌─────▼─────┐   ┌─────▼─────┐
              │   GAME    │   │   GOAL    │
              ├───────────┤   ├───────────┤
              │ id (PK)   │   │ id (PK)   │
              │ team1_id  │   │ player_id │
              │ team2_id  │   │ game_id   │
              │ team1_score   │ minute    │
              │ team2_score   │           │
              │ field     │   │           │
              │ referee_id    │           │
              │ time      │   │           │
              │ created_at    │           │
              └───┬───────┘   └─┬─────────┘
                  │             │
                  │             │
              ┌───▼─────────┐   │
              │ belongsTo   │◄──┘
              │ USER        │
              │(Referee)    │
              └─────────────┘
```

## 🔌 API Endpoints

```
API Routes (JSON Responses)
│
├──► GET /api/teams ──► ApiController::getTeams
│    └─ Returns: List of all teams in JSON format
│
├──► GET /api/users ──► ApiController::getUsers
│    └─ Returns: List of all users in JSON format
│
└──► GET /api/games ──► ApiController::getGames
     └─ Returns: List of all games in JSON format
```

## 📁 Project Directory Structure

```
schoolvoetbal/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php (Register, Login, Logout)
│   │   │   ├── TeamController.php (CRUD Teams)
│   │   │   ├── GameController.php (CRUD Games)
│   │   │   ├── GoalController.php (CRUD Goals)
│   │   │   ├── DashboardController.php (Home page)
│   │   │   ├── AdminController.php (Admin panel)
│   │   │   ├── ApiController.php (JSON APIs)
│   │   │   └── ProfileController.php (User profile)
│   │   │
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php (Check admin status)
│   │   │
│   │   └── Requests/
│   │
│   ├── Models/
│   │   ├── User.php (User model with relationships)
│   │   ├── Team.php (Team model with relationships)
│   │   ├── Game.php (Game model with relationships)
│   │   └── Goal.php (Goal model with relationships)
│   │
│   └── Providers/
│       └── AppServiceProvider.php
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── teams/
│   │   │   ├── index.blade.php (List teams)
│   │   │   ├── show.blade.php (Team details)
│   │   │   ├── create.blade.php (Create form)
│   │   │   └── edit.blade.php (Edit form)
│   │   ├── auth/
│   │   ├── components/
│   │   │   └── (Reusable view components)
│   │   ├── layouts/
│   │   │   └── (Layout templates)
│   │   └── profile/
│   │
│   ├── css/
│   │   └── app.css (Tailwind CSS)
│   │
│   └── js/
│       ├── app.js
│       └── bootstrap.js
│
├── routes/
│   ├── web.php (Web routes - Main routing file)
│   ├── auth.php (Authentication routes)
│   └── console.php
│
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_teams_table.php
│   │   ├── *_create_games_table.php
│   │   ├── *_create_goals_table.php
│   │   └── *_add_team_fk_to_users.php
│   │
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── AdminUserSeeder.php
│   │   ├── TeamsSeeder.php
│   │   ├── GamesSeeder.php
│   │   ├── GoalsSeeder.php
│   │   └── MakeUserAdminSeeder.php
│   │
│   └── factories/
│       └── UserFactory.php
│
├── config/
│   ├── app.php (App configuration)
│   ├── auth.php (Authentication configuration)
│   ├── database.php (Database configuration)
│   └── (other config files)
│
├── public/
│   ├── index.php (Entry point)
│   ├── build/ (Compiled assets)
│   └── robots.txt
│
├── storage/ (Logs, cache, sessions)
├── tests/ (Unit & Feature tests)
├── vendor/ (Composer dependencies)
│
├── artisan (Laravel command tool)
├── composer.json (PHP dependencies)
├── package.json (Node dependencies - Vite, Tailwind)
├── tailwind.config.js
├── vite.config.js
└── phpunit.xml
```

## 🚀 Request Lifecycle

```
HTTP Request
    │
    ├──► (Route: routes/web.php)
    │
    ├──► Middleware Layer
    │    ├─ Check if authenticated
    │    ├─ Check admin role (if needed)
    │    └─ Other middleware
    │
    ├──► Controller Method
    │    ├─ Extract request data
    │    ├─ Validate input
    │    ├─ Query/Modify database
    │    └─ Return response
    │
    ├──► View (Blade Template)
    │    ├─ Render with data
    │    ├─ Apply Tailwind CSS
    │    └─ Include components
    │
    └──► HTTP Response to Client
```

## 📊 Data Flow Example: Creating a Team

```
1. User clicks "Create" button
   └─► GET /teams/create

2. TeamController::create() loads
   └─► Returns teams/create.blade.php view

3. User fills form and submits
   └─► POST /teams (with name, points)

4. TeamController::store() receives request
   ├─ Validates input
   ├─ Creates new Team record
   │  └─► Team model saves to database
   │      └─ team.creator_id = current user ID
   └─ Redirects to teams.index

5. TeamController::index() loads
   ├─ Fetches all Team records from DB
   └─ Returns teams/index.blade.php with teams list

6. View renders
   └─ Loop through teams and display in table
      └─ Each team row has Edit/Delete buttons
```

## 🔄 Complete User Journey

```
START
  │
  ├──► Unauthenticated User
  │    ├─ Visits website
  │    ├─ Sees /register or /login options
  │    ├─ Either:
  │    │  ├─ Creates new account (POST /register)
  │    │  └─ Logs in with existing account (POST /login)
  │    │
  │    └─► Redirected to /home (Dashboard)
  │
  ├──► Authenticated User (Dashboard)
  │    ├─ View profile options
  │    ├─ Navigate to Teams
  │    │  ├─ View all teams (/teams)
  │    │  ├─ Create new team (/teams/create)
  │    │  ├─ View team details (/teams/{id})
  │    │  ├─ Edit team (/teams/{id}/edit)
  │    │  └─ Delete team (/teams/{id})
  │    │
  │    ├─ Manage Games
  │    │  ├─ Create game (associate 2 teams)
  │    │  ├─ Record game results
  │    │  └─ View game history
  │    │
  │    ├─ Track Goals
  │    │  ├─ Add goal entries
  │    │  ├─ Specify player & minute
  │    │  └─ View goal statistics
  │    │
  │    └─ [If Admin]
  │       └─ Access admin panel (/admin)
  │          ├─ Manage all users
  │          ├─ Manage all teams
  │          ├─ Manage all games
  │          └─ Manage all goals
  │
  └──► Logout (POST /logout)
       └─ Destroy session & redirect to /login
```

## 🛡️ Security Features

- **Authentication**: User login/register system
- **Authorization**: Admin middleware for protected routes
- **CSRF Protection**: Token validation on forms
- **Password Hashing**: Secure password storage
- **Middleware**: Auth middleware protects routes
- **Form Validation**: Server-side input validation

## 🎨 Frontend Stack

- **Template Engine**: Laravel Blade
- **CSS Framework**: Tailwind CSS
- **Build Tool**: Vite
- **JavaScript**: Vanilla JS + Bootstrap

## 🗄️ Backend Stack

- **Framework**: Laravel 11
- **Database**: MySQL/PostgreSQL
- **ORM**: Eloquent
- **Testing**: Pest PHP
- **Package Manager**: Composer

---

**Last Updated**: December 2025
**Project**: Schoolvoetbal - Football Management System
