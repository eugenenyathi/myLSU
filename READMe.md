# What is myLSU

It is a system that is designed to allow students to pick their desired friends to be roommates with.

## What stack is it built on?

- Vanilla Javascript (OOP) for Frontend
- Vanilla Php (OOP) for Backend
- MySQL

---

## How does it work?

1. To Login in for the first time, the student is required to use their national id, after the first login the system requires the student to change to a custom password
2. Using the search bar the student can query the desired students to share a room with, then based on the system configurations, the student can select either 2 or 3 room mates.
3. After a successful selection of the desired roommates, the student can then make a room request.
4. You can only make a single request and can not change roommates after you have made a request.
5. The potential roommates selected can either decline or accept to be roommates with the student who made the initial request.
6. If the potential roommates declines they are allowed to pick their own roommates.
7. They system allocates rooms based on first come first save and if any request does not meet the criteria that request is left for random selection. [ This part is done by the allocate-room-engine aka vessel engine.]
8. If for some reason there exist a student who made a request or accepted one and is not allocated a room by the vessel engine, the audit system will allocate the room based on availability.

## How is the data moved from frontend to backend

- all the data is transmitted through javascript & javascript will make the necessary dom changes.

---

## Files section

- all the files that handle requests from the user are found in the /includes directory and are postfixed with .inc.php
- all the files that handle the logic are called from the /includes directory and are found in the /classes directory

## Important

- The entry point of all backend files is through the includes directory and the same goes for the frontend, all the data is sent to the ./includes directory.

## Classes directory structure

- this directory is divided into

  - controllers
  - interfaces
  - models
  - views

- Controllers handle the main logic
- Models interact with the database
- Interfaces handle which model is selected between the male and female model.
- Views handle the data to be transmitted to the frontend Js files.

## Db connection

- database connection files live in the /classes/db directory and use pdo.

---

## Backend Location of the most important files

- Login Files

  - ./includes/login.inc.php
  - ./classes/controllers/login-contr.php
  - ./classes/models/login-model.php

- Search bar files

  - ./includes/searchbar.inc.php
  - ./classes/controllers/searchbar-contr.php
  - ./classes/models/searchbar-model.php

- Request Room Files
  - ./includes/request-room.inc.php
  - ./classes/controllers/rr-contr.php
  - ./classes/interfaces/rr-interface.php
  - ./classes/models/rr-female.php & rr-male.php

* Allocate Rooms Files

  - ./includes/allocate-room.inc.php
  - ./classes/controllers/allocate-room-contr.php
  - ./classes/interfaces/allocate-room-interface.php
  - ./classes/models/allocate-room-models

---

## The main user interface

- all files that handle the initial load data displayed in the user interface are found in the ./center-panel, all the logic that powers the user interface lives in the classes folder, following the order above.
