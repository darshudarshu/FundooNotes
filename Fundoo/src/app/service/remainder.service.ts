import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class RemainderService {
 /**
  * Api urls
  */
  private urlFetchRemainderNote = "http://localhost/codeigniter/fetchRemainderNote";
  private urlchangeDateTime = "http://localhost/codeigniter/changeRemainderDateTime";
  private urlCreateRemainderNotes = "http://localhost/codeigniter/createRemainderNotes";
  private urlDeleteRemainderNote = "http://localhost/codeigniter/deleteRemainderNote";
  constructor(private http: HttpClient) { }

  /**
    * @method fetchRemainderNote() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  fetchRemainderNote(email) {
    ;
    let RemainderNote = new FormData();
    RemainderNote.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchRemainderNote, RemainderNote, otheroption)
  }

  /**
    * @method dateTimeChange() 
    * @return observable data
    * @param email 
    * @param id 
    * @param otherPresentTime            
    * @description Function to send email , otherPresentTime  id to server
    */
  dateTimeChange(id, otherPresentTime, email) {
    let DataTime = new FormData();
    DataTime.append("id", id)
    DataTime.append("email", email)
    DataTime.append("presentDateTime", otherPresentTime)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'

    }
    return this.http.post(this.urlchangeDateTime, DataTime, otheroption)
  }
  /**
    * @method noteData() 
    * @return void
    * @param notes
    * @param email 
    * @param currentDateTime
    * @param color
    * @param isArchive        
    * @param labelname
    * @return observable data
    * @description Function to send note data to server
    */
  noteData(notes, email, currentDateTime, color, isArchive, labelname) {
    let notesData = new FormData();
    notesData.append("email", email)
    notesData.append("title", notes.title)
    notesData.append("notes", notes.note)
    notesData.append("remainder", currentDateTime)
    notesData.append("color", color)
    notesData.append("isArchive", isArchive)
    notesData.append("label", labelname)

    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlCreateRemainderNotes, notesData, otheroption);

  }
  /**
    * @method deleteRemainderNotes() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  deleteRemainderNotes(id, email) {
    let remainderId = new FormData();
    remainderId.append("id", id)
    remainderId.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'

    }
    return this.http.post(this.urlDeleteRemainderNote, remainderId, otheroption)
  }
}
