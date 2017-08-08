#include <fstream>
#include <string>
#include <iostream>
#include <cctype>
#include <iomanip>
using namespace std;
const int MAXSIZE = 20;
const int MAXGM=15;
const int MAXSCR=300;
struct bowler
{
  int idnum; //player's ID#                                                                                                                                                                   
  int totpts; //total scores earned                                                                                                                                                            
  int game_score[MAXGM]; //player's game scores                                                                                                                                                    
  int hw[MAXSIZE]; //player's homework scores                                                                                                                                                  
};
struct b_bowler
{
  string first,last; //player's first & last name                                                                                                                                             
  int id; //player's ID#                                                                                                                                                                      
};
void get_player(b_bowler[],int&x);
void print_table(b_bowler[],int x);
void get_data(bowler[],int&);
void read_scores(ifstream&,int[],int);
void fixstring(string&);
void print_table_detail(bowler[],int);
int total_scores(bowler);
int count_game(bowler);
int main()
{
  bowler league_arr[MAXSIZE];//array to store player info                                                                                                                                         
  b_bowler player_arr[MAXSIZE];
  int n;
  int x; //number of players in the game                                                                                                                                                     
  get_player(player_arr,x);
  print_table(player_arr,x);
  get_data(league_arr,n);                                                                                                                                                                    
  print_table_detail(league_arr,n);
  return 0;
}
void get_player(b_bowler ls[], int& x)
{
  string filenameone; //name of input file     
  ifstream fileone; //input file
  cout << "Please enter the name of the first input file" << endl;
  cin>>filenameone;
  fileone.open(filenameone.c_str());
  x=0;
  fileone>>ls[x].first >> ls[x].last >> ls[x].id;
  while(fileone)
    {
      x++;
      fileone >> ls[x].first >> ls[x].last >> ls[x].id;
      fixstring(ls[x].last);
      fixstring(ls[x].first);
    }
  fileone.close();
}
void print_table(b_bowler ls[],int x)
{
  cout << left << setw(N) << "NAME" << right << setw(N-15) << "ID#"<< endl;
  for (int i=0;i<x;i++)
    {
      cout << setw(N) << left << ls[i].last+','+ls[i].first;
      cout << right << setw(N-15) << ls[i].id  << setw(N-15) << " "   << endl;
    }
}
void get_data(bowler lg[],int& n)
{
  string filenametwo; //name of input file                                                                                                                                                        
  ifstream filetwo; //input file                                                                                                                                                                    
  cout << "Please enter the name of the second input file" << endl;
  cin >> filenametwo;
  in.open(filenametwo.c_str());
  n=0;
  in >>lg[n].idnum;
 while(in)
   {
     lg[n].totpts=0;
     read_scores(in,lg[n].game_score);
     read_scores(in,lg[n].p_score);
     n++;
     in >>lg[n].idnum;
   }
 in.close();
  }
void read_scores(ifstream& in,int list[])
{
  int i=0;
  in >> list[i];
  while(in>>list[i] && list[i] != -1)
    {
          in >> list[i];
          i++;
    }
}
void fixstring(string& word)
{
  int wlen=word.length();
  word[0] = toupper(word[0]);
  for (int i=1; i<wlen; i++)
    word[i] = tolower(word[i]);
}
void print_table_detail(bowler list[],int n)
{
  int scores=0;
  char grade;
  int count=0;
  cout << left << setw(N) << "ID#" << right << setw(N-15) << "TOTAL"
       << setw(N-15) << "GAMES" << endl;
  for (int i =0; i < n; i++)
    {
          scores = total_scores(list[i]);
          count = count_game(list[i]);
          list[i].totpts = scores;
          cout << left <<setw(12)<< list[i].idnum << right << setw(N-15) << scores << setw(N-15) << count<< endl;
    }
}
int total_scores(bowler league_player)
{
  int total=0, i=0;
  for (int i=0; i<MAXGM; i++)
    {
      total = total+league_player.game_score[i];
    }
  for (int i=0; i<MAXSIZE; i++)
  {
    total = total+league_player.p_score[i];
  }
  return total;
}

