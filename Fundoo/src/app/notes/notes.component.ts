
declare let require: any;
import { element } from 'protractor';
import { Component, OnInit, OnDestroy, Inject } from '@angular/core';
import {
  NgForm
} from "@angular/forms";
import { CdkDragDrop, moveItemInArray } from '@angular/cdk/drag-drop';
import { NoteserviceService } from "../service/noteservice.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
import { Subscription } from 'rxjs';
import { CommonService } from '../service/common.service';
import { ArchiveService } from '../service/archive.service';
import { Router } from "@angular/router";
import { CommonlabelService } from '../service/commonlabel.service';
import { CollabaratorService } from "../service/collabarator.service";
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { EditnotesComponent } from './../editnotes/editnotes.component';
import { CollabaratorComponent } from './../collabarator/collabarator.component';
import { CreatecollabaratorComponent } from './../createcollabarator/createcollabarator.component';
import { LabelService } from "../service/label.service";
import { ImageService } from '../service/image.service';
import { Notes } from "../core/model/note";
import { Labels } from "../core/model/note";
import { Collaborators } from "../core/model/note";
import { LoggerserviceService } from "../service/loggerservice/loggerservice.service";
@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.css']
})
/**
 * @class NotesComponent set of codes to operate on user notes 
 */
export class NotesComponent implements OnInit, OnDestroy {
  /**
   * variable 
   */
  obs;
  /**
   * variable to check whether the error occured or not
   */
  public isArchived = "no";

  /**
    * variable to  store selected labels 
    */
  public labelname = null;
  /**
    * variable to check the error
    */
  public iserror = false;
  /**
  * variable to toggle between grid and List view 
  */
  public grid: boolean;
  /**
  * variable to hold present time
  */
  public PresentTime;
  /**
 * variable to hold present time
 */
  public otherPresentTime;
  /**
  * to show error message
  */
  public errorMessage = "";
  /**
  * var to hold present time
  */
  public currentDateAndTime = "";
  /**
  * variable which holds the color of note
  */
  public color = "";
  /**
  * variable of type subscription
  */
  private subscription: Subscription;
  /**
  * variable of type subscription
  */
  private searchSubscription: Subscription;
  /**
  * array to hold user notes data
  */
  model: any = {};
  /**
  * array to users notes
  */
  notes: Notes[] = [];
  /**
   * variable to to store labels 
   */
  labels: Labels[] = [];
  /**
   * variable to store all colaberartor
   */
  collabarators: Collaborators[] = [];
  /**
  * variable to hold user email
  */
  email: string = "";
  /**
  * variable to hold search data
  */
  searchData;
  constructor(
    private LoggerserviceService: LoggerserviceService,
    private image: ImageService,
    private collabaratorService: CollabaratorService,
    private commonlabelService: CommonlabelService,
    private labelservice: LabelService,
    private archiveService: ArchiveService,
    public dialog: MatDialog,
    private router: Router,
    private notesService: NoteserviceService,
    private _cookieService: CookieService,
    private commonService: CommonService) {
    /**
    * subscribing the notifyObservable variable in common service
    */
    this.subscription = this.commonService.notifyObservable$.subscribe((res) => {
      this.grid = res;
    });
    /**
     * subscribing the notifyObservable variable in common service
     */
    this.searchSubscription = this.commonService.searchDataObservable$.subscribe((res) => {
      this.searchData = res;
    });

    /**
    * method which runs over every 1 second
    */
    setInterval(() => {
      this.remainder();
    }, 15000);
  }
  /**
   * @method remainder()
   * @return void  
   */
  remainder() {
    let dateFormat = require("dateformat");
    /**
     * for each runs to check wheather the user time matches with current time 
     */
    this.notes.forEach(element => {
      let now = new Date();
      /**
       * formating the current time to the required time format
       */
      let currentTime = dateFormat(now, "hh:MM tt");
      /**
       * formating the current date to the required format
       */
      let currentDate = dateFormat(now, "dd/mm/yyyy");
      let DateAndTime = currentDate + " " + currentTime;
      this.currentDateAndTime = DateAndTime;
      /**
       * compare with present time if equal alert remainder
       */
      if (DateAndTime == element.remainder) {
        alert("remainder");
      }
    });
  }
  displayMain = false;
  displayOtherCards = false;
  timer_button = false;
  timer_panel = false;
  other_timer_button = false;
  other_timer_panel = false;
  remainder_id = "";
  note_id = "";

  /**
   * variable holding all main collabarators
   */
  mainCollabarators;
  /**
    * @method ngOnInit() 
    * @return void
    * @description Function to fetch the data from source
    */
  ngOnInit() {
    debugger;
    this.email = this._cookieService.get('email');
    /**
     * loading notes while refreshing the page
     */
    this.obs = this.notesService.noteUserData(this.email);
    this.obs.subscribe(
      (res: any) => {
        /**
         * assing response to the user notes
         */
        this.notes = res;
        LoggerserviceService.log("darshu")
        
        // obs.unsubscribe();

      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;

      });
    let obss = this.labelservice.fetchLabels(this.email);
    obss.subscribe(
      (res: any) => {
        /**
         * assing response to the user labels
                               
         */
        this.labels = res;
        // obss.unsubscribe();

      });
    let obsss = this.collabaratorService.fetchCollabaratorsOfNotes(this.email);
    obsss.subscribe(
      (res: any) => {
        this.collabarators = res;

      });

    let obbs = this.collabaratorService.fetchCollabarators(1111, this.email);
    obbs.subscribe(
      (res: any) => {
        this.mainCollabarators = res;

      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
  }
  /**
   * @var difference intger having the difference
   * @var dirrection string having the direction of drag
   */
  difference;
  dirrection;
  /**
   * @method drop 
   * @description function to drag and drop the card 
   * @param CdkDragDrop array
   */
  drop(event: CdkDragDrop<string[]>) {
    moveItemInArray(this.notes, event.previousIndex, event.currentIndex);
    if ((event.previousIndex - event.currentIndex) >= 0) {
      this.difference = (event.previousIndex - event.currentIndex);
      // alert("pas");
      this.dirrection = "positive"
    }
    else {
      this.difference = (event.previousIndex - event.currentIndex) * -1;
      // alert("neg");
      this.dirrection = "negative"
    }
    let obbs = this.notesService.dragAndDrop(this.difference, this.notes[event.currentIndex].dragId, this.dirrection, this.email);
    obbs.subscribe(
      (res: any) => {
        // obbs.unsubscribe();
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
  }
  /**
  * @method saveTimeDate()
  * @return void
  * @description Function to store the user entered date and time
  */
  saveTimeDate() {
    let dateFormat = require("dateformat");
    let currentDate = dateFormat(this.model.date, "dd/mm/yyyy");
    this.currentDateAndTime = currentDate + " " + this.model.time;
    this.PresentTime = this.currentDateAndTime;
    if (this.model.date != null && this.model.time != null) {
      this.timer_button = true;
      this.timer_panel = false;
    }
  }
  /**
  * @method clearTimeDate()
  * @return void
  * @description Function to clear the user entered date and time
  */
  clearTimeDate() {
    this.model.date = null;
    this.model.time = null;
    this.PresentTime = null;
    this.timer_button = false;
  }
  isHaveCollabarator = true;
  /**
  * @method displayMethod()
  * @return void
  * @description Function to store the user entered notes data
  */
  displayMethod() {
    if (this.mainCollabarators[0] == undefined) {
      this.isHaveCollabarator = false;
    } else {
      this.isHaveCollabarator = true;
    }
    this.displayMain = !this.displayMain;
    this.email = this._cookieService.get('email');
    if (this.model.note != null && this.model.title != null && this.model.title != "") {
      /**
      * calling the function and subscribing to its response notedata present in the notesservice and 
      */
      this.obs = this.notesService.noteData(this.model, this.email, this.PresentTime, this.color, this.isArchived, this.labelname, this.isHaveCollabarator);
      this.obs.subscribe(
        (res: any) => {
          /**
           * Checking the authorised user or not
           */
          if (res.error == 404) {
            alert("Unathourized User");
            localStorage.removeItem("token");
            this.router.navigate(['/login'])
            // obs.unsubscribe();

          } else {
            this.notes = res;
            let obsss = this.collabaratorService.fetchCollabaratorsOfNotes(this.email);
            obsss.subscribe(
              (ress: any) => {
                this.collabarators = ress;
              });
            let obbs = this.collabaratorService.fetchCollabarators(1111, this.email);
            obbs.subscribe(
              (res: any) => {
                this.mainCollabarators = res;
                // obbs.unsubscribe();

              }, error => {
                this.iserror = true;
                this.errorMessage = error.message;
              });
            // obs.unsubscribe();
          }
        },
        error => {
          this.iserror = true;
          this.errorMessage = error.message;
        });
      this.model.title = null;
      this.model.note = null;
    } else {
      let obbs = this.collabaratorService.deleteAllMainCollabarators(1111, this.email);
      obbs.subscribe(
        (res: any) => {
          this.mainCollabarators = res;
          // obbs.unsubscribe();

        }, error => {
          this.iserror = true;
          this.errorMessage = error.message;
        });
    }
    this.color = null;
    this.isArchived = "no";
  }
  /**
   * @method ngOnDestroy()
   * @return void
   * @description function which destroy the subscription
   */
  ngOnDestroy() {
    this.subscription.unsubscribe();
    this.searchSubscription.unsubscribe();
    // this.obs.unsubscribe();
  }
  /**
   * @method setColor()
   * @return void
   * @param changecolor
   * @description function to save the color to the database
   */
  setColor(id, changecolor) {
    let obs = this.notesService.colorChange(id, changecolor);
    obs.subscribe(
      (res: any) => {
        // obs.unsubscribe();
      });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.color = changecolor;
      }
    });
  }
  /**
  * @method setColorToTitle()
  * @return void
  * @param changecolor
  * @description Function to set colour to title card
  */
  setColorToTitle(changecolor) {
    this.color = changecolor;
  }
  /**
* @method othertimepanel()
* @return void
* @param id
* @description Function to opon time panel card
*/
  othertimepanel(id) {
    this.notes.forEach(element => {
      if (element.id == id) {
        this.other_timer_panel = !this.other_timer_panel;
        this.remainder_id = id;
      }
    });
  }
  /**
  * @method otherClearTimeDate()
  * @return void
  * @param id
  * @description Function to clear the user entered date and time
  */
  otherSaveTimeDate(id) {
    let dateFormat = require("dateformat");
    let currentDate = dateFormat(this.model.date, "dd/mm/yyyy");
    this.currentDateAndTime = currentDate + " " + this.model.time;
    this.notes.forEach(element => {
      if (element.id == id) {
        element.remainder = this.currentDateAndTime;
        this.otherPresentTime = this.currentDateAndTime;
      }
    });
    if (this.model.date != null && this.model.time != null) {
      let obs = this.notesService.dateTimeChange(id, this.otherPresentTime);
      obs.subscribe(
        (res: any) => {
          // obs.unsubscribe();
        });
      this.other_timer_button = true;
      this.other_timer_panel = false;
    }
  }
  /**
  * @method otherClearTimeDate()
  * @return void
  * @param id
  * @description Function to clear the user entered date and time
  */
  otherClearTimeDate(id) {
    this.notes.forEach(element => {
      if (element.id == id) {
        element.remainder = 'undefined';
        this.otherPresentTime = 'undefined';
        this.model.date = null;
        this.model.time = null;
        this.other_timer_button = false;
      }
    });
    let obs = this.notesService.dateTimeChange(id, this.otherPresentTime);
    obs.subscribe(
      (res: any) => {
        // obs.unsubscribe();
      });
  }
  /**
  * @method today()
  * @return void
  * @param id
  * @description Function to select today
  */
  today(id) {
    this.other_timer_button = true
    this.notes.forEach(element => {
      if (element.id == id) {
        element.remainder = this.currentDateAndTime;
        this.otherPresentTime = this.currentDateAndTime;
      }
    });
    let obs = this.notesService.dateTimeChange(id, this.otherPresentTime);
    obs.subscribe(
      (res: any) => {
        // obs.unsubscribe();
      });
  }
  flag = true;
  /**
   * @method deleteNote()
   * @return void
   * @param id
   * @description Function to delete the note
   */
  deleteNote(id) {
    this.collabarators.forEach(element => {
      if (element.noteId == id) {
        ;
        this.flag = false;
        if (element.owner == this.email) {
          alert("allow delete");
          let obs = this.notesService.deleteThisNote(id, this.email);
          obs.subscribe(
            (res: any) => {
              if (res.error == 202) {
                alert("Unknown data");
                // obs.unsubscribe();

              }
              else {
                /**
                 * assing response to the user notes
                 */
                this.notes = res;
                // obs.unsubscribe();

              }
            });
        } else {
          alert("remove my self");
          let obs = this.collabaratorService.deleteCollabarators(element.id, this.email, this.email, element.noteId);
          obs.subscribe(
            (res: any) => {
              this.collabarators = res;
              // obs.unsubscribe();

            }, error => {
              this.iserror = true;
              this.errorMessage = error.message;
            });

          let obssss = this.notesService.noteUserData(this.email);
          obssss.subscribe(
            (res: any) => {
              /**
               * assing response to the user notes
               */
              this.notes = res;
              // obssss.unsubscribe();

            }, error => {
              this.iserror = true;
              this.errorMessage = error.message;
            });
        }
      }
    });
    if (this.flag) {
      let obs = this.notesService.deleteThisNote(id, this.email);
      obs.subscribe(
        (res: any) => {
          if (res.error == 202) {
            alert("Unknown data");
            // obs.unsubscribe();

          }
          else {
            /**
             * assing response to the user notes
             */
            this.notes = res;
          }
        });
    }
  }
  /**
  * @method openDialog()
  * @return void
  * @param user 
  * @description Function to open the dialogbox of editer component
  */
  openDialog(user): void {
    const dialogRef = this.dialog.open(EditnotesComponent, {
      // width: '200px',height:'200px',
      data: { user: user }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result != undefined) {
        this.notes = result;
      }
    });
  }
  /**
  * @method archiveNote()
  * @return void
  * @param id 
  * @description Function to archive note
  */
  archiveNote(id) {
    let obs = this.archiveService.archiveThisNote(id, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
          // obs.unsubscribe();

        }
        else {
          // this.notes = res;
          let obss = this.notesService.noteUserData(this.email);
          obss.subscribe(
            (res: any) => {
              /**
               * assing response to the user notes
               */
              this.notes = res;
              // obss.unsubscribe();

            }, error => {
              this.iserror = true;
              this.errorMessage = error.message;
            });
        }
      });
  }
  /**
  * @method setLabel()
  * @return void
  * @param id 
  * @param Label
  * @description Function to set the label
  */
  setLabel(id, Label) {

    let obs = this.notesService.setLabels(id, Label);
    obs.subscribe(
      (res: any) => { });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.label = Label;
      }
    });
  }
  /**
  * @method deleteLabel()
  * @return void
  * @param id
  * @description Function to delete label
  */
  deleteLabel(id) {
    let obs = this.notesService.deleteLabels(id);
    obs.subscribe(
      (res: any) => {
        // obs.unsubscribe();
      });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.label = null;
      }
    });
  }
  /**
  * @method sendLabelName()
  * @return void
  * @param selectedLabel
  * @description Function to set selected label
  */
  sendLabelName(selectedLabel) {
    /**
     * sending data to commonservice notifyOther method
     * @param selectedLabel  
     */
    this.commonlabelService.notifyLabel(selectedLabel);
  }
  /**
  * @method openCollabarator()
  * @param user
  * @return void
  * @description Function to open the existing collabarotor 
  */
  openCollabarator(user): void {
    const dialogRef = this.dialog.open(CollabaratorComponent, {
      width: '600px',
      data: { user: user }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result != undefined) {
        this.collabarators = result;
        let obs = this.notesService.noteUserData(this.email);
        obs.subscribe(
          (res: any) => {
            /**
             * assing response to the user notes
             */
            this.notes = res;
            // obs.unsubscribe();

          }, error => {
            this.iserror = true;
            this.errorMessage = error.message;
          });
      }
    });
  }
  /**
  * @method createCollabarator()
  * @return void
  * @description Function to open create collabarotoe dilog box
  */
  createCollabarator(): void {
    const dialogRef = this.dialog.open(CreatecollabaratorComponent, {
      width: '600px',
      data: { user: "user" }
    });
    dialogRef.afterClosed().subscribe(result => {
      this.mainCollabarators = result;
    });
  }

  /**
   * var to hold image base64url
   */
  public base64textString;
  /**
   * variable to store the note id of image to be added
   */
  imageNoteId;
  /**
  * @method onSelectFile()
  * @return void
  * @description Function to save the image 
  */
  onSelectFile(event, noteId) {
    debugger;
    this.imageNoteId = noteId;
    var files = event.target.files;
    var file = files[0];
    if (files && file) {
      var reader = new FileReader();
      reader.onload = this._handleReaderLoaded.bind(this);
      reader.readAsBinaryString(file);
    }
  }

  _handleReaderLoaded(readerEvt) {
    var binaryString = readerEvt.target.result;
    console.log(binaryString);
    this.base64textString = btoa(binaryString);
    this.notes.forEach(element => {
      if (element.id == this.imageNoteId) {
        element.image = "data:image/jpeg;base64," + this.base64textString;
      }
    });

    let obss = this.image.noteSaveImage(this.base64textString, this.email, this.imageNoteId);
    obss.subscribe(
      (res: any) => {
      });

  }
}
