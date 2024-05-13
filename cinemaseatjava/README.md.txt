Movie Reservation System
The Movie Reservation System is a Java application designed to facilitate the management of movie bookings and seat reservations. It provides functionality for administrators, managers, and customers to interact with the system.

Functionality
Admin Features:

Login: Admins can log in to the system using a predefined username and password.
Add Manager: Admins can add new managers to the system by providing a unique username and password.
Remove Manager: Admins can remove existing managers from the system.
View Added Managers: Admins can view the list of managers currently registered in the system.
View Feedback: Admins can view feedback provided by customers.
Manager Features:

Add Movie: Managers can add new movies to the system by providing details such as movie name, description, release date, date to watch, time to watch, genre, and duration.
Delete Movie: Managers can delete existing movies from the system.
Update Movie Date and Time: Managers can update the date and time of a movie already added to the system.
View Movies: Managers can view the list of movies added to the system.
Customer Features:

Display Movies: Customers can view the list of available movies.
Book a Seat: Customers can book seats for a specific movie by selecting the movie and entering their name and preferred seat number.
Display Available Seats: Customers can view the available seats for a specific movie.
Cancel a Seat: Customers can cancel their booked seats for a specific movie.
View Updated Date and Time: Customers can view the updated date and time for a movie if it has been changed.
Send Feedback: Customers can provide feedback about their experience with the system.
Usage Instructions
Admin Login:

To access admin features, log in with the username "admin" and password "adminpassword".
Manager Login:

Managers should enter their username and password to access manager features.
Customer Interaction:

Customers can navigate the system to view movies, book seats, cancel seats, and provide feedback.
Note
The system is designed to handle a maximum of 100 movies, 10 managers, and 50 seats per movie.
Date and time formats are enforced for consistency and correctness.
Feedback provided by customers is stored and can be viewed by admins.
How to Run
Compile the Java files using javac MovieReservationSystem.java.
Run the compiled program using java MovieReservationSystem.
Follow the prompts to navigate through the system and utilize its features.