Project Overview

This project implements a fully functional Monster Talent Show web application built with PHP, MySQL, JavaScript, and custom CSS. It includes dynamic features such as monster profiles, competitions, voting, reviews, merchandise, a shopping cart, and user accounts. The goal was to create an interactive, database‑driven website with clean UI, responsive design, and reliable backend logic.

What I Built

Dynamic monster system with voting, reviews, and favourites
Competition pages with active, upcoming, and past filtering
Shop and merchandise system with cart, stock logic, and recommendations
Session‑based user accounts including login, logout, and profile
Image resolution logic that loads correct merch/monster images with fallbacks
Responsive UI using custom CSS and layout grids
Theme switching system (optional enhancement)

What I Learned

How to structure a full PHP/MySQL application with reusable components
How to manage sessions for login, cart, and theme persistence
How to write secure SQL queries using prepared statements
How to design scalable CSS using variables and consistent architecture
How to debug complex interactions between PHP, JS, and the database
How to ensure good UX through clear feedback, fallbacks, and responsive design

Challenges & Solutions

Dynamic image loading Solved by creating a PHP resolver that checks DB images, slug matches, and fallbacks.
Session handling across pages Fixed by standardizing session_start() and ensuring fetch requests include credentials.
Cart and quantity updates Implemented POST‑based actions with validation and automatic redirects to prevent resubmission.
Theme switching Added a session‑based system with optional preview and toggle button.

Reflection

This project helped me understand how to build a complete, interactive web application from scratch. I learned how to combine backend logic with frontend design, how to structure a database‑driven site, and how to solve real‑world problems like image handling, user sessions, and responsive layouts. I also improved my debugging skills and gained confidence in writing clean, maintainable code.
Overall, the project strengthened my understanding of full‑stack development and gave me practical experience building a polished, user‑friendly application.
