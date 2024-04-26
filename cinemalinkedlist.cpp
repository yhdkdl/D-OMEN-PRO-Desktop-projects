#include <iostream>
#include <fstream>
#include <iomanip>
#include <string>
using namespace std;

struct SeatNode {
    int seat;
    bool booked;
    string customerName;
    SeatNode* next;
};

struct Movie {
    string movieName;
    string description;
    string releaseDate;
    string dateAndTime;
    string genre;
    int duration;
    SeatNode* seatList;
    Movie* next;
};

struct Movie* start = NULL;
void saveFile();

void insertMovieBegin() {
   string movieName, description, releaseDate ,date ,time, genre;
    int duration;
    cout << "Enter movie details:\n";
    cout << "Movie Name: ";
    cin.ignore();  
    getline(cin, movieName);

    cout << "Description: ";
    getline(cin, description);
m:
    cout << "Release Date (format: YYYY-MM-DD): ";
    getline(cin, releaseDate);
    if (releaseDate.length() == 10 &&
        stoi(releaseDate.substr(0, 4)) >= 1900 && stoi(releaseDate.substr(0, 4)) <= 2024 &&
        stoi(releaseDate.substr(5, 2)) >= 1 && stoi(releaseDate.substr(5, 2)) <= 12 &&
        stoi(releaseDate.substr(8, 2)) >= 1 && stoi(releaseDate.substr(8, 2)) <= 30) {

    } else {
        cout << "Invalid release date format or values. Please enter a valid date.\n";
        goto m;
    }
    n:
cout << "Enter the date (format: YYYY-MM-DD): ";
    cin >> date;
	  if (date.length() == 10 &&
       stoi(date.substr(0, 4)) == 2024 &&
        stoi(date.substr(5, 2)) >= 1 && stoi(date.substr(5, 2)) <= 12 &&
        stoi(date.substr(8, 2)) >= 1 && stoi(date.substr(8, 2)) <= 30) {

    } else {
        cout << "Invalid release date format or values. Please enter a valid date.\n";
        goto n;
    }

   s:
    cout << "Enter the time (format: HH:MM): ";
    cin >> time;
	  if (time.length() == 5 &&
                stoi(time.substr(0, 2)) >= 0 && stoi(time.substr(0, 2)) <= 23 &&
                stoi(time.substr(3, 2)) >= 0 && stoi(time.substr(3, 2)) <= 59) {
				  } else {
                cout << "Invalid time format or values. Please enter a valid time (HH:MM).\n";
        goto s;
        }


    cout << "Genre: ";
 cin>> genre;
 b:
  cout << "Duration (in minutes): ";
    cin >> duration;
if(duration>350){
    cout<<"duration minute to long input again\n";
goto b;
}

 string dateAndTime = date + " " + time;

    struct Movie* newMovie = new Movie{
        movieName, description, releaseDate, dateAndTime, genre, duration, NULL, NULL
    };


    for (int i = 1; i <= 50; ++i) {
        SeatNode* newSeat = new SeatNode{ i, false, "" };
        newSeat->next = newMovie->seatList;
        newMovie->seatList = newSeat;
    }

    if (start == NULL) {
        start = newMovie;
    } else {
        newMovie->next = start;
        start = newMovie;
    }

    cout << "Movie added at the beginning successfully!\n";
}
void insertMovieEnd() {
    string movieName, description, releaseDate ,date ,time, genre;
    int duration;

    cout << "Enter movie details:\n";
    cout << "Movie Name: ";
    cin.ignore();  
    getline(cin, movieName);

    cout << "Description: ";
    getline(cin, description);

   a:
    cout << "Release Date (format: YYYY-MM-DD): ";
    getline(cin, releaseDate);
    if (releaseDate.length() == 10 &&

        stoi(releaseDate.substr(0, 4)) >= 1900 && stoi(releaseDate.substr(0, 4)) <= 2024 &&
        stoi(releaseDate.substr(5, 2)) >= 1 && stoi(releaseDate.substr(5, 2)) <= 12 &&
        stoi(releaseDate.substr(8, 2)) >= 1 && stoi(releaseDate.substr(8, 2)) <= 30) {

    } else {
        cout << "Invalid release date format or values. Please enter a valid date.\n";
        goto a;
    }

     i:
cout << "Enter the date (format: YYYY-MM-DD): ";
    cin >> date;
	  if (date.length() == 10 &&
        stoi(date.substr(0, 4)) == 2024 &&
        stoi(date.substr(5, 2)) >= 1 && stoi(date.substr(5, 2)) <= 12 &&
        stoi(date.substr(8, 2)) >= 1 && stoi(date.substr(8, 2)) <= 30) {

    } else {
        cout << "Invalid release date format or values. Please enter a valid date.\n";
        goto i;
    }

   p:
    cout << "Enter the time (format: HH:MM): ";
    cin >> time;
	  if (time.length() == 5 &&
                stoi(time.substr(0, 2)) >= 0 && stoi(time.substr(0, 2)) <= 23 &&
                stoi(time.substr(3, 2)) >= 0 && stoi(time.substr(3, 2)) <= 59) {
				  } else {
                cout << "Invalid time format or values. Please enter a valid time (HH:MM).\n";
        goto p;
        }


    cout << "Genre: ";
      cin>> genre;

     l:
  cout << "Duration (in minutes): ";
    cin >> duration;
if(duration>350){
    cout<<"duration minute to long input again\n";
goto l;
}
string dateAndTime = date + " " + time;
    struct Movie* newMovie = new Movie{
        movieName, description, releaseDate, dateAndTime, genre, duration, NULL
    };
     for (int i = 1; i <= 50; ++i) {
        SeatNode* newSeat = new SeatNode{ i, false, "" };
        newSeat->next = newMovie->seatList;
        newMovie->seatList = newSeat;
    }


    if (start == NULL) {
        start = newMovie;
    } else {
        struct Movie* temp = start;
        while (temp->next != NULL) {
            temp = temp->next;
        }
        temp->next = newMovie;
    }

    cout << "Movie added at the end successfully!\n";
}
void insertMovieMiddle() {
   string movieName, description, releaseDate ,date ,time, genre;
    int duration;

    cout << "Enter movie details:\n";
    cout << "Movie Name: ";
    cin.ignore();  
    getline(cin, movieName);

    cout << "Description: ";
    getline(cin, description);

    o:
    cout << "Release Date (format: YYYY-MM-DD): ";
    getline(cin, releaseDate);
    if (releaseDate.length() == 10 &&

        stoi(releaseDate.substr(0, 4)) >= 1900 && stoi(releaseDate.substr(0, 4)) <= 2024 &&
        stoi(releaseDate.substr(5, 2)) >= 1 && stoi(releaseDate.substr(5, 2)) <= 12 &&
        stoi(releaseDate.substr(8, 2)) >= 1 && stoi(releaseDate.substr(8, 2)) <= 30) {

    } else {
        cout << "Invalid release date format or values. Please enter a valid date.\n";
        goto o;
    }

     l:
cout << "Enter the date (format: YYYY-MM-DD): ";
    cin >> date;
	  if (date.length() == 10 &&
        stoi(date.substr(0, 4)) == 2024 &&
        stoi(date.substr(5, 2)) >= 1 && stoi(date.substr(5, 2)) <= 12 &&
        stoi(date.substr(8, 2)) >= 1 && stoi(date.substr(8, 2)) <= 30) {

    } else {
        cout << "Invalid release date format or values. Please enter a valid date.\n";
        goto l;
    }

   k:
    cout << "Enter the time (format: HH:MM): ";
    cin >> time;
	  if (time.length() == 5 &&
                stoi(time.substr(0, 2)) >= 0 && stoi(time.substr(0, 2)) <= 23 &&
                stoi(time.substr(3, 2)) >= 0 && stoi(time.substr(3, 2)) <= 59) {
				  } else {
                cout << "Invalid time format or values. Please enter a valid time (HH:MM).\n";
        goto k;
        }


    cout << "Genre: ";
    cin>> genre;

    c:
  cout << "Duration (in minutes): ";
    cin >> duration;
if(duration>350){
    cout<<"duration minute to long input again\n";
goto c;
}
string dateAndTime = date + " " + time;
    struct Movie* newMovie = new Movie{
        movieName, description, releaseDate, dateAndTime, genre, duration, NULL
    };
     for (int i = 1; i <= 50; ++i) {
        SeatNode* newSeat = new SeatNode{ i, false, "" };
        newSeat->next = newMovie->seatList;
        newMovie->seatList = newSeat;
    }


    if (start == NULL) {
        start = newMovie;
        cout << "Movie added at the beginning successfully!\n";
        return;
    }

    struct Movie* s = start;
    struct Movie* f = start;
    struct Movie* p = NULL;

    while (f != NULL && f->next != NULL) {
        f = f->next->next;
        p = s;
        s = s->next;
    }

    newMovie->next = s;
    if (p == NULL) {

        start = newMovie;
    } else {
        
        p->next = newMovie;
    }

    cout << "Movie added in the middle successfully!\n";
}

void displayMovies() {
    if (start == NULL) {
        cout << "No movies in the list." << endl;
    } else {
        cout << "--------------------------------------------------------------------------------------------------------------------------\n";
        cout << "  No. | Movie Name           | Description                             | Release Date | Date to watch      | Time to watch    \n";
        cout << "--------------------------------------------------------------------------------------------------------------------------\n";

        int movieNumber = 1;
        struct Movie* temp = start;
        while (temp != NULL) {
            // Adjusting spacing for alignment
            cout << setw(5) << left << movieNumber << " | ";
            cout << setw(20) << left << temp->movieName.substr(0, 20) << " | ";
            cout << setw(40) << left << temp->description.substr(0, 40) << " | ";
            cout << setw(13) << left << temp->releaseDate << " | ";

            if (temp->dateAndTime.length() >= 16) {
                cout << setw(10) << left << temp->dateAndTime.substr(0, 10) << " | ";
                cout << setw(8) << left << temp->dateAndTime.substr(11, 5) << endl;
            } else {
                cout << setw(10) << left << "N/A" << " | ";
                cout << setw(8) << left << "N/A" << endl;
            }

            ++movieNumber;
            temp = temp->next;
        }

        cout << "--------------------------------------------------------------------------------------------------------------------------\n";
    }
}

void displaySeats(Movie& movie) {
    SeatNode* temp = movie.seatList;
    int count = 0;

    cout << "\n---------------------\n";
    cout << "Available seats for " << movie.movieName << " at " << movie.dateAndTime << "\n";
    cout << "---------------------\n";

    while (temp) {
        if (temp->seat / 10 == 0)
            cout << "S0" << temp->seat << " :";
        else
            cout << "S" << temp->seat << " :";

        if (!temp->booked)
            cout << "|__empty___| ";
        else
            cout << "|____" << temp->customerName << "____| ";

        count++;

        if (count % 5 == 0) {
            cout << endl;
        }

        temp = temp->next;
    }
}



void bookSeat(Movie& movie) {
    int seat;
    string name;

    cout << "Enter seat number to be booked: ";
    cin >> seat;

    cout << "Enter your name: ";
    cin >> name;

    SeatNode* temp = movie.seatList;

    while (temp && temp->seat != seat) {
        temp = temp->next;
    }

    if (temp) {
        if (temp->booked) {
            cout << "Seat already booked!\n";
        } else {
            temp->booked = true;
            temp->customerName = name;
            cout << "Seat " << seat << " booked for " << name << endl;
            saveFile();
        }
    } else {
        cout << "Invalid seat number!\n";
    }
}

void cancelSeat(Movie& movie) {
    int seat;
    string name;

    cout << "Enter seat number to cancel booking: ";
    cin >> seat;

    cout << "Enter your name: ";
    cin >> name;

    SeatNode* temp = movie.seatList;

    while (temp && temp->seat != seat) {
        temp = temp->next;
    }

    if (temp) {
        if (!temp->booked) {
            cout << "Seat not booked yet!\n";
        } else {
            if (temp->customerName == name) {
                temp->booked = false;
                temp->customerName = "";
                cout << "Seat canceled!\n";
                saveFile();
            } else {
                cout << "Wrong user name, seat cannot be canceled!\n";
            }
        }
    } else {
        cout << "Invalid seat number!\n";
    }
}

void deleteMovieBegin() {
    if (start == NULL) {
        cout << "No movies to delete (list is empty)." << endl;
    } else {
        Movie* temp = start;
        start = start->next;
        delete temp;
        cout << "Movie deleted successfully from the beginning." << endl;
    }
}

void deleteMovieMiddle() {
    if (start == NULL) {
        cout << "No movies to delete (list is empty)." << endl;
    } else {
        Movie* s = start;
        Movie* f = start;
        Movie* p = NULL;

        while (f != NULL && f->next != NULL) {
            f = f->next->next;
            p = s;
            s = s->next;
        }

        if (p == NULL) {
            start = start->next;
        } else {
            p->next = s->next;
        }

        delete s;
        cout << "Movie deleted successfully from the middle." << endl;
    }
}

void deleteMovieEnd() {
    if (start == NULL) {
        cout << "No movies to delete (list is empty)." << endl;
    } else {
        Movie* p = start;
        Movie* p1 = NULL;

        while (p->next != NULL) {
            p1 = p;
            p = p->next;
        }

        if (p1 != NULL) {
            p1->next = NULL;
        } else {
            start = NULL;
        }

        delete p;
        cout << "Movie deleted successfully from the end." << endl;
    }
}
void updateMovieDateTime() {
    int movienum;
    string newDate, newTime;

    cout << "Enter the index of the movie to update its date and time: ";
    cin >> movienum;

    if (movienum >= 1 && movienum <= 6 && start) {
        t:
        cout << "Enter the new date (format: YYYY-MM-DD): ";
        cin >> newDate;
        if (newDate.length() == 10 &&
            stoi(newDate.substr(0, 4)) <= 2024 &&
            stoi(newDate.substr(5, 2)) >= 1 && stoi(newDate.substr(5, 2)) <= 12 &&
            stoi(newDate.substr(8, 2)) >= 1 && stoi(newDate.substr(8, 2)) <= 30) {
        } else {
            cout << "Invalid new date format or values. Please enter a valid date.\n";
            goto t;
        }
    y:
        cout << "Enter the new time (format: HH:MM): ";
        cin >> newTime;
        if (newTime.length() == 5 &&
            stoi(newTime.substr(0, 2)) >= 0 && stoi(newTime.substr(0, 2)) <= 23 &&
            stoi(newTime.substr(3, 2)) >= 0 && stoi(newTime.substr(3, 2)) <= 59) {
        } else {
            cout << "Invalid time format or values. Please enter a valid time (HH:MM).\n";
            goto y;
        }

        // Concatenate new date and time properly
        string newDateAndTime = newDate + " " + newTime;

        Movie* selectedMovie = start;
        for (int i = 1; i < movienum && selectedMovie != NULL; ++i) {
            selectedMovie = selectedMovie->next;
        }

        if (selectedMovie != NULL) {
            selectedMovie->dateAndTime = newDateAndTime;
            cout << "Movie date and time updated successfully!\n";
        } else {
            cout << "Invalid movie index!\n";
        }
    } else {
        cout << "Invalid movie index!\n";
    }
}


void managerMenu() {
    int managerChoice;
    do{
        cout << "\nwelcome to Manager Menu\n";
        cout << "1. Add movie at the beginning" << endl;
        cout << "2. Add movie at the middle" << endl;
        cout << "3. Add movie at the end" << endl;
        cout << "4. Delete movie from the beginning" << endl;
        cout << "5. Delete movie from the middle" << endl;
       cout << "6. Delete movie from the last" << endl;
         cout << "7. Update movie date and time" << endl;
        cout << "8. Exit\n";
        cout << "Enter your choice: ";
        cin >> managerChoice;
        system("cls");
        switch (managerChoice) {
            case 1:
                insertMovieBegin();
                break;
            case 2:
                insertMovieMiddle();
                break;
            case 3:
                insertMovieEnd();
                break;
            case 4:
                deleteMovieBegin();
                break;
            case 5:
                deleteMovieMiddle();
                break;
            case 6:
                deleteMovieEnd();
                break;
                 case 7:
                updateMovieDateTime();
                break;
            case 8:
                cout << "Thank you for using the system  !" << endl;
                break;
            default:
                cout << "Invalid choice. Please try again." << endl;
                break;
        }
        } while ( managerChoice!= 8);
    }
void customerMenu(){
    int customerChoice;
    do{
        cout << "\nWelcome to Dalak Cinema Customer Menu\n";
        cout << "1. Display movies" << endl;
         cout << "2. Book a seat(1-50)" << endl;
        cout << "3. Display available seats(1-50)" << endl;
       cout << "4. Cancel a seat(1-50)" << endl;
        cout << "5. Exit" << endl;
         cout << "Enter your choice: ";
        cin >> customerChoice;
        system("cls");
        switch (customerChoice){
           case 1:
            displayMovies();
            break;
    case 2:
    if (start != NULL) {

        displayMovies();


        int selectedMovieNumber;
        cout << "Enter the movie number to book a seat: ";
        cin >> selectedMovieNumber;


        Movie* selectedMovie = start;
        for (int i = 1; i < selectedMovieNumber && selectedMovie != NULL; ++i) {
            selectedMovie = selectedMovie->next;
        }
        if (selectedMovie != NULL) {
            bookSeat(*selectedMovie);
        } else {
            cout << "Invalid movie selection.\n";
        }
    } else {
        cout << "No movies available to book a seat.\n";
    }
    break;
                case 3:
                    if (start != NULL) {

        displayMovies();


        int selectedMovieNumber;
        cout << "Enter the movie number to display available seats: ";
        cin >> selectedMovieNumber;


        Movie* selectedMovie = start;
        for (int i = 1; i < selectedMovieNumber && selectedMovie != NULL; ++i) {
            selectedMovie = selectedMovie->next;
        }


        if (selectedMovie != NULL) {
            displaySeats(*selectedMovie);
        } else {
            cout << "Invalid movie selection.\n";
        }
    } else {
        cout << "No movies available to display available seats.\n";
    }
break;
     case 4:
                if (start != NULL) {

                    displayMovies();

                    int selectedMovieNumber;
                    cout << "Enter the movie number to cancel a seat: ";
                    cin >> selectedMovieNumber;


                    Movie* selectedMovie = start;
                    for (int i = 1; i < selectedMovieNumber && selectedMovie != NULL; ++i) {
                        selectedMovie = selectedMovie->next;
                    }


                    if (selectedMovie != NULL) {
                        cancelSeat(*selectedMovie);
                    } else {
                        cout << "Invalid movie selection.\n";
                    }
                } else {
                    cout << "No movies available to cancel a seat.\n";
                }
                break;
            case 5:
                cout << "Thank you for using the dalak Cinema System!" << endl;
                break;
            default:
                cout << "Invalid choice. Please try again." << endl;
                break;
        }
        } while (customerChoice != 5);
    }
bool managerLogin() {
    const string managerUsername = "manager";
    const string managerPassword = "password";
    string username, password;
    int attempts = 3;

    do {
        cout << "Manager Login\n";
        cout << "Username: ";
        cin >> username;

        cout << "Password: ";
        cin >> password;

        if (username == managerUsername && password == managerPassword) {
            cout << "Login successful!\n";
            return true;
        } else {
            cout << "Incorrect username or password. " << attempts - 1 << " attempts left.\n";
            attempts--;

            if (attempts == 0) {
                cout << "Too many incorrect attempts. Exiting the program.\n";
                exit(0);
            }
        }
    } while (true);
}
void run() {
          char userType;
    cout << "*******************************************************************\n";
    cout << "           DALAK CINEMA MOVIE SEAT RESERVATION SYSTEM\n";
    cout << "*******************************************************************\n";
    cout << "Please choose the selection to proceed:\n";
    cout << "Are you a manager (m)\n";
    cout << "Are you a customer (c)\n";
      cout << "Input [M/C]: ";
    cin >> userType;

    if (userType == 'm' || userType == 'M') {
        if (managerLogin()) {
            managerMenu();
        }
    } else if (userType == 'c' || userType == 'C') {
        customerMenu();
    } else {
        cout << "Invalid user type. Exiting the program.\n";
    }

}

void loadFromFile() {
   ifstream inputFile("movies.txt");
    if (!inputFile) {
        cerr << "Error opening the file for reading." << endl;
        return;
    }

    string line;
    while (getline(inputFile, line)) {
        Movie* newMovie = new Movie;
        newMovie->movieName = line;
        getline(inputFile, newMovie->description);
        getline(inputFile, newMovie->releaseDate);
        getline(inputFile, newMovie->dateAndTime);
        getline(inputFile, newMovie->genre);
        inputFile >> newMovie->duration;

        for (int i = 1; i <= 50; ++i) {
            SeatNode* newSeat = new SeatNode{ i, false, "" };
            inputFile >> newSeat->seat >> newSeat->booked;
            getline(inputFile, newSeat->customerName);
            newSeat->next = newMovie->seatList;
            newMovie->seatList = newSeat;
        }

        newMovie->next = start;
        start = newMovie;

        // Read the "END" marker
        getline(inputFile, line);
    }

    inputFile.close();
}
void saveFile() {
    ofstream outFile("movies.txt");
    if (!outFile.is_open()) {
        cout << "Error opening file for writing." << endl;
        return;
    }

    Movie* temp = start;
    while (temp != NULL) {
        outFile << "Movie Name:"<< temp->movieName << '\n';
        outFile  << "Description:"<< temp->description << '\n';
        outFile << "Release  Date:"<< temp->releaseDate << '\n';
        outFile << "Date and Time to watch:"<< temp->dateAndTime << '\n';
        outFile  << "Genre: "<< temp->genre << '\n';
        outFile  << "Duratione: "<< temp->duration << '\n';

        SeatNode* seatTemp = temp->seatList;
        int seatCount = 0;

        while (seatTemp != NULL) {
            if (seatCount % 5 == 0) {
                outFile << '\n';  // Start a new line after every 5 seats
            }

            if (seatTemp->seat < 10)
                outFile << "S0" << seatTemp->seat << " :";
            else
                outFile << "S" << seatTemp->seat << " :";

            if (!seatTemp->booked)
                outFile << "|__empty___| ";
            else
                outFile << "|____" << seatTemp->customerName << "____| ";

            seatTemp = seatTemp->next;
            seatCount++;
        }

  outFile << '\n';
        temp = temp->next;
    }

    outFile.close();
}
int main() {
     loadFromFile();
  int choice;
    char repeat = 'y';

    while (repeat == 'y' || repeat == 'Y') {
        run();
        saveFile();
cout << "\nDo you want to perform another operation? (y/n): ";
        cin >> repeat;

        system("cls");
    }

    cout << "Thank you for visiting our site. Come again!\n";

    return 0;
}




