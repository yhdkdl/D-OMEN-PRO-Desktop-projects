The Movie Reservation System  offers a range of functionalities tailored to three types of users: admins, managers, and customers. Here is an overview of what the system does with each functionality:

Admin Functionalities
Admin Login:

Admins can log in using a predefined username and password.
Admin Menu:

Add a New Manager: Admins can add a new manager by providing a unique username and password.
Remove a Manager: Admins can remove an existing manager by specifying the manager's username.
Display Managers: Admins can view the list of all added managers, including their usernames and passwords.
View Feedback: Admins can view feedback provided by customers.
File Operations:

Save Managers to File: After adding or removing a manager, the updated list is saved to a file (managers.txt).
Load Managers from File: On system startup, the list of managers is loaded from the file.
Manager Functionalities
Manager Login:

Managers can log in by providing their username and password.
Manager Menu:

Add a New Movie: Managers can add a new movie by providing details such as movie name, description, release date, watch date and time, genre, and duration.
Delete a Movie: Managers can delete an existing movie by specifying its name.
Update Movie Date and Time: Managers can update the date and time for an existing movie, preserving the previous date and time.
Display Movies: Managers can view a list of all added movies along with their details.
File Operations:

Save Movies to File: The list of movies, along with their details and seating arrangements, is saved to a file (movies.txt) after any modification.
Load Movies from File: On system startup, the list of movies is loaded from the file.
Customer Functionalities
Customer Menu:
Display Movies: Customers can view a list of all available movies along with their details.
Book a Seat: Customers can book a seat for a specific movie by providing their name and selecting an available seat.
Display Available Seats: Customers can view the seating arrangement for a specific movie, showing which seats are available and which are booked.
Cancel a Seat: Customers can cancel a booked seat for a specific movie.
View Updated Date and Time: Customers can view the updated date and time for a specific movie, along with the previous date and time if it has been updated.
Send Feedback: Customers can send feedback about their experience, which is stored in the system for admins to review.
Additional Features
Initialization of Seats: Each movie has a seating arrangement initialized with 50 seats, all set to unbooked by default.
Data Persistence: The system saves and loads manager and movie data to and from files to ensure data persistence across sessions.
Input Validation: The system includes validation for dates and times to ensure they are in the correct format and within acceptable ranges.
Sample Workflow
Admin Adds a Manager:

Admin logs in and selects the option to add a new manager.
Admin enters a unique username and password for the new manager.
The system saves the updated manager list to the file.
Manager Adds a Movie:

Manager logs in and selects the option to add a new movie.
Manager enters the movie details.
The system initializes the seating and saves the movie details to the file.
Customer Books a Seat:

Customer views the list of movies and selects one.
Customer views the available seats and selects a seat to book.
Customer provides their name, and the system updates the seating arrangement.
The system saves the updated movie details to the file.
Feedback:

Customers can send feedback, which admins can later review.