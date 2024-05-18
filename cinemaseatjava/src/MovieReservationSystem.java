import java.io.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

abstract class Admin {
    private String username;
    private String password;

    public Admin(String username, String password) {
        this.username = username;
        this.password = password;
    }

    // Getter for username
    public String getUsername() {
        return this.username;
    }

    // Getter for password
    public String getPassword() {
        return this.password;
    }
}

class Manager extends Admin {
    public Manager(String username, String password) {
        super(username, password);
    }
    // No need to redefine methods, as they are inherited from Admin
}

class Seat {
    int seat;
    boolean booked;
    String customerName;
     int bookingId;

    Seat(int seat, boolean booked, String customerName) {
        this.seat = seat;
        this.booked = booked;
        this.customerName = customerName;
           this.bookingId = -1;
    }
}

class Movie {
    String movieName;
    String description;
    String releaseDate;
    String date;
    String Time;
    String genre;
    int duration;
    Seat[] seatList;
    String previousDate;
    String previousTime;
    boolean updated;

    Movie(String movieName, String description, String releaseDate, String date, String Time, String genre, int duration) {
        this.movieName = movieName;
        this.description = description;
        this.releaseDate = releaseDate;
        this.date = date;
        this.Time = Time;
        this.genre = genre;
        this.duration = duration;
        this.seatList = new Seat[50]; // Assuming a maximum of 50 seats
        initializeSeats();
        this.updated = false;
        this.previousDate = date;
        this.previousTime = Time;
    }

    private void initializeSeats() {
        for (int i = 0; i < seatList.length; i++) {
            seatList[i] = new Seat(i + 1, false, null);
        }
    }
}


public class MovieReservationSystem {
    static List<String> feedbackList = new ArrayList<>();
    static Admin[] admins = new Admin[2];
    static int adminCount = 0;

    static Manager[] managers = new Manager[10]; // Assuming a maximum of 10 managers
    static int managerCount = 0;

    static Movie[] movies = new Movie[100]; // Assuming a maximum of 100 movies
    static int movieCount = 0;
    static final int TOTAL_SEATS = 50;
     static int nextBookingId = 1;

    public static void main(String[] args) {
        loadManagersFromFile();
        loadFromFile();
        Scanner scanner = new Scanner(System.in);
        char repeat = 'y';

        while (repeat == 'y' || repeat == 'Y') {
            run(scanner);
            saveFile();
            saveManagersToFile();
            System.out.println("\nDo you want to perform another operation? (y/n): ");
            repeat = scanner.next().charAt(0);
        }

        System.out.println("Thank you for using the Movie Reservation System!");
    }

    static void run(Scanner scanner) {
    boolean validInput = false;

    while (!validInput) {
        System.out.println("*******************************************************************");
        System.out.println("           MOVIE SEAT RESERVATION SYSTEM");
        System.out.println("*******************************************************************");
        System.out.println("Please choose the selection to proceed:");
        System.out.println("Are you an admin (a)");
        System.out.println("Are you a manager (m)");
        System.out.println("Are you a customer (c)");
        System.out.println("Input [A/M/C]: ");
        char userType = scanner.next().charAt(0);

        if (userType == 'a' || userType == 'A') {
            if (adminLogin(scanner)) {
                adminMenu(scanner);
                validInput = true; // Set to true to exit the loop
            }
        } else if (userType == 'm' || userType == 'M') {
            System.out.print("Enter your username: ");
            String username = scanner.next();
            System.out.print("Enter your password: ");
            String password = scanner.next();
            boolean found = false;
            for (Manager manager : managers) {
                if (manager != null && manager.getUsername().equals(username) && manager.getPassword().equals(password)) {
                    found = true;
                    break;
                }
            }
            if (found) {
                managerMenu(scanner);
                validInput = true; // Set to true to exit the loop
            } else {
                System.out.println("Manager not registered or incorrect username/password.");
            }
        } else if (userType == 'c' || userType == 'C') {
            customerMenu(scanner);
            validInput = true; // Set to true to exit the loop
        } else {
            System.out.println("Invalid user type. Please enter 'a', 'm', or 'c'.");
            // Loop continues for invalid input
        }
    }
}

    static boolean adminLogin(Scanner scanner) {
        final String adminUsername = "admin";
        final String adminPassword = "adminpassword";
        String username, password;

        System.out.println("Admin Login");

        System.out.print("Username: ");
        username = scanner.next();

        System.out.print("Password: ");
        password = scanner.next();

        if (username.equals(adminUsername) && password.equals(adminPassword)) {
            System.out.println("Login successful!");
            return true;
        } else {
            System.out.println("Incorrect username or password.");
            return false;
        }
    }

    
    static void adminMenu(Scanner scanner) {
    int adminChoice;

    do {
        System.out.println("\nWelcome to Admin Menu");
        System.out.println("1. Add a new manager");
        System.out.println("2. Remove a manager");
        System.out.println("3. View added managers list");
        System.out.println("4. View feedback");
        System.out.println("5. Exit");
        System.out.println("Enter your choice: ");

        // Check if the next input is an integer
        if (scanner.hasNextInt()) {
            adminChoice = scanner.nextInt();
            scanner.nextLine(); // Consume newline character

            switch (adminChoice) {
                case 1:
                    addManager(scanner);
                    break;
                case 2:
                    removeManager(scanner);
                    break;
                case 3:
                    displayManagers();
                    break;
                case 4:
                    viewFeedback();
                    break;
                case 5:
                    System.out.println("Exiting admin menu.");
                    break;
                default:
                    System.out.println("Invalid choice. Please try again.");
                    break;
            }
        } else {
            System.out.println("Invalid input. Please enter a number.");
            scanner.next(); // Consume the invalid input to prevent an infinite loop
            adminChoice = -1; // Set adminChoice to an invalid value to ensure the loop continues
        }
    } while (adminChoice != 5);
}

  static void addManager(Scanner scanner) {
    String username, password;

    
    do {
        System.out.println("Enter the username of the new manager: ");
        username = scanner.next();

        boolean usernameExists = false;
        for (Manager manager : managers) {
            if (manager != null && manager.getUsername().equals(username)) {
                System.out.println("Username already exists. Please choose another username.");
                usernameExists = true;
                break;
            }
        }
        if (!usernameExists) {
            break; // If the username is unique, exit the loop
        }
    } while (true);

  
    do {
        System.out.println("Enter the password of the new manager: ");
        password = scanner.next();

        boolean passwordExists = false;
        for (Manager manager : managers) {
            if (manager != null && manager.getPassword().equals(password)) {
                System.out.println("Password already used. Please choose another password.");
                passwordExists = true;
                break;
            }
        }
        if (!passwordExists) {
            break; // If the password is unique, exit the loop
        }
    } while (true);

    Manager newManager = new Manager(username, password);
    managers[managerCount++] = newManager;
  saveManagersToFile(); // Save managers to file after adding a new manager
    System.out.println("Manager added successfully!");
}



    static void removeManager(Scanner scanner) {
        System.out.println("Enter the username of the manager to remove: ");
        String username = scanner.next();

        // Search for the manager with the given username
        for (int i = 0; i < managerCount; i++) {
            if (managers[i].getUsername().equals(username)) {
                // Shift the array elements to remove the manager
                for (int j = i; j < managerCount - 1; j++) {
                    managers[j] = managers[j + 1];
                }
                managerCount--;
                System.out.println("Manager removed successfully.");
                return;
            }
        }

        System.out.println("Manager not found.");
    }
      static void displayManagers() {
        System.out.println("Added Managers:");
        for (int i = 0; i < managerCount; i++) {
            Manager manager = managers[i];
            System.out.println("Username: " + manager.getUsername() + " | Password: " + manager.getPassword());
        }
    }
      private static void saveManagersToFile() {
    try (BufferedWriter writer = new BufferedWriter(new FileWriter("managers.txt"))) {
        for (int i = 0; i < managerCount; i++) {
            Manager current = managers[i];
            writer.write( current.getUsername() + ":" + current.getPassword());
            writer.newLine();
        }
    } catch (IOException e) {
        System.err.println("Error saving managers file: " + e.getMessage());
    }
}

private static void loadManagersFromFile() {
    File file = new File("managers.txt");
    if (!file.exists()) {
        try {
            file.createNewFile();
            System.out.println("File 'managers.txt' created successfully.");
        } catch (IOException e) {
            System.err.println("Error creating managers file: " + e.getMessage());
            return;
        }
    }

    try (BufferedReader reader = new BufferedReader(new FileReader(file))) {
        String line;
        while ((line = reader.readLine()) != null) {
            String[] parts = line.split(":");
            if (parts.length == 2) {
                String username = parts[0];
                String password = parts[1];
                Manager newManager = new Manager(username, password);
                managers[managerCount++] = newManager;
            }
        }
    } catch (IOException e) {
        System.err.println("Error reading managers file: " + e.getMessage());
    }
}

    static void managerMenu(Scanner scanner) {
        int managerChoice = 0; // Initialize managerChoice variable

   do {
        System.out.println("\nWelcome to Manager Menu");
        System.out.println("1. Add a new movie");
        System.out.println("2. Delete a movie");
        System.out.println("3. Update movie date and time");
        System.out.println("4. Display movies added");
        System.out.println("5. Exit");
        System.out.println("Enter your choice: ");
         if (scanner.hasNextInt()) {
            managerChoice = scanner.nextInt();
            scanner.nextLine();// Consume newline character

        switch (managerChoice) {
            case 1:
                addMovie(scanner);
                break;
            case 2:
                deleteMovie(scanner);
                break;
            case 3:
                updateMovieDateTime(scanner);
                break;
            case 4:
                displayMovies();
                break;          
            case 5:
                System.out.println("Thank you for using the system!");
                break;
            default:
                System.out.println("Invalid choice. Please try again.");
                break;
        }
         }else {
            System.out.println("Invalid input. Please enter a number.");
            scanner.next(); // Consume the invalid input to prevent an infinite loop
            managerChoice = -1; // Set adminChoice to an invalid value to ensure the loop continues
         }
    } while (managerChoice != 5);
}
    
    static void updateMovieDateTime(Scanner scanner) {
        System.out.println("Enter the name of the movie to update date and time: ");
        String movieName = scanner.nextLine();
        Movie current = findMovieByName(movieName);

        if (current == null) {
            System.out.println("Movie not found.");
            return;
        }

        System.out.println("Enter new date: ");
        String newDate = scanner.nextLine();
        System.out.println("Enter new time: ");
        String newTime = scanner.nextLine();

        // Save previous date and time before updating
        current.previousDate = current.date;
        current.previousTime = current.Time;

        current.date = newDate;
        current.Time = newTime;

        // Set the updated flag to true
        current.updated = true;

        System.out.println("Date and time updated successfully.");
    }
 static void viewUpdatedDateTime(Scanner scanner) {
        System.out.println("Enter the name of the movie to view updated date and time: ");
        String movieName = scanner.nextLine();
        Movie current = findMovieByName(movieName);

        if (current == null) {
            System.out.println("Movie not found.");
            return;
        }

        if (current.updated) {
            System.out.println("Previous date and time: " + current.previousDate + " " + current.previousTime);
            System.out.println("Updated date and time: " + current.date + " " + current.Time);
        } else {
            System.out.println("No updated date and time for " + movieName + ".");
        }
    }
    static void displayMovies() {
        if (movieCount == 0) {
            System.out.println("No movies in the list.");
        } else {
            System.out.println("--------------------------------------------------------------------------------------------------------------------------");
            System.out.println("  No. | Movie Name           | Description                             | Release Date | Date to watch      | Time to watch    ");
            System.out.println("--------------------------------------------------------------------------------------------------------------------------");

            for (int i = 0; i < movieCount; i++) {
                Movie current = movies[i];
                // Adjusting spacing for alignment
                System.out.printf("%5d | %-20s | %-40s | %-13s | %-10s | %-8s\n", (i + 1), current.movieName.substring(0, Math.min(current.movieName.length(), 20)), current.description.substring(0, Math.min(current.description.length(), 40)), current.releaseDate, current.date, current.Time);
            }

            System.out.println("--------------------------------------------------------------------------------------------------------------------------");
        }
    }

    static void customerMenu(Scanner scanner) {
        int customerChoice;
        do {
            System.out.println("\nWelcome to Movie Reservation System Customer Menu");
            System.out.println("1. Display movies");
            System.out.println("2. Book a seat");
            System.out.println("3. Display available seats");
            System.out.println("4. Cancel a seat");
            System.out.println("5. View updated date and time for a movie");
              System.out.println("6. Send feedback ");
        System.out.println("7. Exit");
            System.out.println("Enter your choice: ");
            if (scanner.hasNextInt()) {
            customerChoice = scanner.nextInt();
            scanner.nextLine();

            switch (customerChoice) {
                case 1:
                    displayMovies();
                    break;
                case 2:
                    bookSeat(scanner);
                    break;
                case 3:
                    displayAvailableSeats(scanner);
                    break;
                case 4:
                    cancelSeat(scanner);
                    break;
                case 5:
                    viewUpdatedDateTime(scanner);
                    break;
                  case 6:
                sendFeedback(scanner);
                break;
            case 7:
                System.out.println("Thank you for using the Movie Reservation System!");
                break;
            default:
                System.out.println("Invalid choice. Please try again.");
                break;
            }
        }else {
            System.out.println("Invalid input. Please enter a number.");
            scanner.next(); // Consume the invalid input to prevent an infinite loop
           customerChoice = -1; // Set adminChoice to an invalid value to ensure the loop continues
         }
    } while (customerChoice != 7);
}
  static void sendFeedback(Scanner scanner) {
        System.out.println("Enter your feedback: ");
        String feedback = scanner.nextLine();
    feedbackList.add(feedback);
    
        System.out.println("Feedback sent successfully: " + feedback);
    }
  static void viewFeedback() {
    if (feedbackList.isEmpty()) {
        System.out.println("No feedback available.");
        return;
    }
    System.out.println("Feedback from customers:");
    for (String feedback : feedbackList) {
        System.out.println("- " + feedback);
    }
}
    static void displayAvailableSeats(Scanner scanner) {
    System.out.println("Enter the name of the movie to display available seats:");
    String movieName = scanner.nextLine();
    Movie current = findMovieByName(movieName);

    if (current == null) {
        System.out.println("Movie not found.");
        return;
    }

    System.out.println("\n---------------------");
    System.out.println("Available seats for " + current.movieName + " at " + current.date + " " +current.Time);
    System.out.println("---------------------");

    boolean anyAvailableSeat = false;

    int rowCount = 0;
    for (Seat seat : current.seatList) {
        if (!seat.booked) {
            // If seat not found or currentSeat is null, it means the seat is available
            System.out.print("S" + (seat.seat < 10 ? "0" : "") + seat.seat + " : |__empty____| ");
            anyAvailableSeat = true;
        } else {
            // If seat is found and booked, print customer name
            System.out.print("S" + (seat.seat < 10 ? "0" : "") + seat.seat + " : |____" + seat.customerName + "____| ");
        }

        // Move to the next row after printing 5 seats
        rowCount++;
        if (rowCount == 5) {
            System.out.println(); // Add a new line
            rowCount = 0; // Reset the row count
        }
    }

    // If there's no available seat, print a message
    if (!anyAvailableSeat) {
        System.out.println("No seats available for this movie.");
    } else {
        System.out.println(); // Add a new line at the end
    }

    System.out.println("---------------------");
}
  
 
  
    static void bookSeat(Scanner scanner) {
        System.out.print("Enter the name of the movie to book a seat for: ");
        String movieName = scanner.nextLine();

        Movie movie = findMovieByName(movieName);
        if (movie == null) {
            System.out.println("Movie not found.");
            return;
        }

        System.out.print("Enter your name: ");
        String customerName = scanner.nextLine();

        System.out.print("Enter the seat number to book (1-" + TOTAL_SEATS + "): ");
        int seatNumber = scanner.nextInt();
        scanner.nextLine(); // Consume newline character

        if (seatNumber < 1 || seatNumber > TOTAL_SEATS) {
            System.out.println("Invalid seat number. Please enter a number between 1 and " + TOTAL_SEATS + ".");
            return;
        }

        Seat seat = movie.seatList[seatNumber - 1];
        if (seat.booked) {
            System.out.println("Seat already booked.");
            return;
        }

        seat.booked = true;
        seat.customerName = customerName;
        seat.bookingId = nextBookingId++;
        System.out.println("Seat booked successfully. Booking ID: " + seat.bookingId);
    }

    static void cancelSeat(Scanner scanner) {
        System.out.print("Enter the name of the movie to cancel the seat for: ");
        String movieName = scanner.nextLine();

        Movie movie = findMovieByName(movieName);
        if (movie == null) {
            System.out.println("Movie not found.");
            return;
        }

        System.out.print("Enter the seat number to cancel (1-" + TOTAL_SEATS + "): ");
        int seatNumber = scanner.nextInt();
        scanner.nextLine(); // Consume newline character
          System.out.print("Enter your booking ID to cancel the seat: ");
            int bookingId = scanner.nextInt();
    scanner.nextLine(); // Consume newline character

        if (seatNumber < 1 || seatNumber > TOTAL_SEATS) {
            System.out.println("Invalid seat number. Please enter a number between 1 and " + TOTAL_SEATS + ".");
            return;
        }

         Seat targetSeat = movie.seatList[seatNumber - 1];
    if (!targetSeat.booked) {
        System.out.println("Seat is not booked.");
        return;
    }

        boolean seatCancelled = false;
          for (Seat seat : movie.seatList) {
        if (seat.bookingId == bookingId) {
            seat.booked = false;
            seat.customerName = null;
            seat.bookingId = -1;
            System.out.println("Seat booking cancelled successfully.");
            seatCancelled = true;
            break;
        }
    }

    if (!seatCancelled) {
        System.out.println("ID incorrect, try again.");
    }
    }

 static void addMovie(Scanner scanner) {
    System.out.println("Enter movie details:");
    System.out.print("Movie Name: ");
    String movieName = scanner.nextLine();
    System.out.print("Description: ");
    String description = scanner.nextLine();
    String releaseDate = null;
    boolean validReleaseDate = false;
    while (!validReleaseDate) {
        System.out.print("Release Date (YYYY-MM-DD): ");
        releaseDate = scanner.nextLine();
        if (isValidReleaseDate(releaseDate)) {
            validReleaseDate = true;
        } else {
            System.out.println("Invalid release date format or out of range. Please enter again.");
        }
    }
    String dateToWatch = null;
    boolean validDateToWatch = false;
    while (!validDateToWatch) {
        System.out.print("Date to watch (YY-MM-DD): ");
        dateToWatch = scanner.nextLine();
        if (isValidDateToWatch(dateToWatch)) {
            validDateToWatch = true;
        } else {
            System.out.println("Invalid date to watch format or out of range. Please enter again.");
        }
    }
    String Timetowatch = null;
    boolean ValidTime = false;
    while (!ValidTime) {
        System.out.print("Time (HH:MM): ");
        Timetowatch = scanner.nextLine();
        if (isValidTime(Timetowatch)) {
            ValidTime = true;
        } else {
            System.out.println("Invalid time format or out of range (maximum 24:00). Please enter again.");
        }
    }
    System.out.print("Genre: ");
    String genre = scanner.nextLine();
    System.out.print("Duration (in minutes): ");
    int duration = scanner.nextInt();
    scanner.nextLine(); // Consume newline character

    Movie newMovie = new Movie(movieName, description, releaseDate, dateToWatch, Timetowatch, genre, duration);
    movies[movieCount++] = newMovie;
    System.out.println("Movie added successfully!");
}

static boolean isValidDateToWatch(String dateToWatch) {
    try {
        String[] parts = dateToWatch.split("-");
        if (parts.length != 3) {
            return false;
        }
        int year = Integer.parseInt(parts[0]);
        int month = Integer.parseInt(parts[1]);
        int day = Integer.parseInt(parts[2]);
        if (year != 2024 || month < 1 || month > 12 || day < 1 || day > 30) {
            return false;
        }
        return true;
    } catch (NumberFormatException e) {
        return false;
    }
}

static boolean isValidTime(String Timetowatch) {
    try {
        String[] parts = Timetowatch.split(":");
        if (parts.length != 2) {
            return false;
        }
        int hour = Integer.parseInt(parts[0]);
        int minute = Integer.parseInt(parts[1]);
        if (hour < 0 || hour > 23 || minute < 0 || minute > 59 || (hour == 24 && minute != 0)) {
            return false;
        }
        return true;
    } catch (NumberFormatException e) {
        return false;
    }
}

    static boolean isValidReleaseDate(String releaseDate) {
        String[] parts = releaseDate.split("-");
        if (parts.length != 3) {
            return false;
        }
        try {
            int year = Integer.parseInt(parts[0]);
            int month = Integer.parseInt(parts[1]);
            int day = Integer.parseInt(parts[2]);
            if (year < 1990 || year > 2024 || month < 1 || month > 12 || day < 1 || day > 30) {
                return false;
            }
        } catch (NumberFormatException e) {
            return false;
        }
        return true;
    }

    static Movie findMovieByName(String movieName) {
        for (int i = 0; i < movieCount; i++) {
            if (movies[i].movieName.equalsIgnoreCase(movieName)) {
                return movies[i];
            }
        }
        return null;
    }

    static void deleteMovie(Scanner scanner) {
        System.out.println("Enter the name of the movie to delete: ");
        String movieName = scanner.nextLine();

        for (int i = 0; i < movieCount; i++) {
            if (movies[i].movieName.equalsIgnoreCase(movieName)) {
                for (int j = i; j < movieCount - 1; j++) {
                    movies[j] = movies[j + 1];
                }
                movieCount--;
                System.out.println("Movie deleted successfully.");
                return;
            }
        }
        System.out.println("Movie not found.");
    }

  private static void saveFile() {
    try (BufferedWriter writer = new BufferedWriter(new FileWriter("movies.txt"))) {
        for (int i = 0; i < movieCount; i++) {
            Movie current = movies[i];
            writer.write("Movie Name:" + current.movieName);
            writer.newLine();
            writer.write("Description:" + current.description);
            writer.newLine();
            writer.write("Release Date:" + current.releaseDate);
            writer.newLine();
            writer.write("Date and Time to watch:" + current.date + " " + current.Time);
            writer.newLine();
            writer.write("Genre:" + current.genre);
            writer.newLine();
            writer.write("Duration:" + current.duration);
            writer.newLine();

            int seatCount = 0;
            for (Seat seat : current.seatList) {
                if (seatCount % 5 == 0 && seatCount != 0) {
                    writer.newLine(); // Start a new line after every 5 seats
                }

                if (seat.seat < 10) {
                    writer.write("S0" + seat.seat + " :");
                } else {
                    writer.write("S" + seat.seat + " :");
                }

                if (!seat.booked) {
                    writer.write("|__empty___| ");
                } else {
                    writer.write("|____" + seat.customerName + "____| ");
                }

                seatCount++;
            }

            writer.newLine(); // Separate movies by a newline
        }
    } catch (IOException e) {
        System.err.println("Error saving file: " + e.getMessage());
    }
}
private static void loadFromFile() {
    File file = new File("movies.txt");
    if (!file.exists()) {
        System.out.println("File 'movies.txt' does not exist.");
        return;
    }

    try (BufferedReader reader = new BufferedReader(new FileReader(file))) {
        String line;
        while ((line = reader.readLine()) != null) {
            if (line.startsWith("Movie Name:")) {
                String movieName = line.substring(11).trim();
                String description = reader.readLine().substring(11).trim();
                String releaseDate = reader.readLine().substring(13).trim();
                String dateTime = reader.readLine().substring(20).trim();
                String[] dateTimeParts = dateTime.split(" ");
                String date = dateTimeParts[0];
                String time = dateTimeParts[1];
                String genre = reader.readLine().substring(7).trim();
                int duration = Integer.parseInt(reader.readLine().substring(9).trim());

                Movie newMovie = new Movie(movieName, description, releaseDate, date, time, genre, duration);

                for (int i = 0; i < TOTAL_SEATS; i++) {
                    String seatInfo = reader.readLine();
                    if (seatInfo == null) {
                        break; // Exit the loop if there are no more lines to read
                    }
                    seatInfo = seatInfo.trim();
                    int seatNumber = Integer.parseInt(seatInfo.substring(1, 3)); // Extract the seat number
                    boolean booked = seatInfo.contains("______"); // Check if the seat is booked
                    String customerName = "";
                    if (booked) {
                        customerName = seatInfo.substring(seatInfo.indexOf("______") + 4, seatInfo.lastIndexOf("______"));
                    }

                    newMovie.seatList[i] = new Seat(seatNumber, booked, customerName);
                }

                movies[movieCount++] = newMovie;
            }
        }
    } catch (IOException e) {
        System.err.println("Error reading file: " + e.getMessage());
    }
}
    }
