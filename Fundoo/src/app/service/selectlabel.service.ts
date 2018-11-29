import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SelectlabelService {
 /**
  * Api urls
  */
  private urlFetchLabelNote = "http://localhost/codeigniter/fetchLabelNote";
  private urlchangeLabelDateTime = "http://localhost/codeigniter/changeLabelDateTime";
  private urlCreateLabelNotes = "http://localhost/codeigniter/createLabelNotes";
  private urlDeleteLabelNote = "http://localhost/codeigniter/deleteLabelNote";
  private urlDeleteNoteLabel = "http://localhost/codeigniter/deleteNoteLabels";
  constructor(private http: HttpClient) { }

  /**
    * @method fetchRemainderNote() 
    * @return observable data
    * @param email 
    * @param label 
    * @description Function to send email and label to server
    */
  fetchRemainderNote(label, email) {
    ;
    let fetchData = new FormData();
    fetchData.append("label", label)
    fetchData.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchLabelNote, fetchData, otheroption)
  }
  /**
    * @method dateTimeChange() 
    * @return observable data
    * @param email 
    * @param id 
    * @param otherPresentTime            
    * @param label 
    * @description Function to send email , otherPresentTime , label and id to server
    */
  dateTimeChange(id, otherPresentTime, label, email) {
    let DataTime = new FormData();
    DataTime.append("id", id)
    DataTime.append("label", label)
    DataTime.append("email", email)
    DataTime.append("presentDateTime", otherPresentTime)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'

    }
    return this.http.post(this.urlchangeLabelDateTime, DataTime, otheroption)
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
    return this.http.post(this.urlCreateLabelNotes, notesData, otheroption);

  }
  /**
    * @method deleteRemainderNotes() 
    * @return observable data
    * @param email 
    * @param id 
    * @param label 
    * @description Function to send email,label and id to server
    */
  deleteRemainderNotes(id, label, email) {
    let remainderId = new FormData();
    remainderId.append("id", id)
    remainderId.append("label", label)
    remainderId.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'

    }
    return this.http.post(this.urlDeleteLabelNote, remainderId, otheroption)
  }
  /**
    * @method deleteLabels() 
    * @return observable data
    * @param email 
    * @param id 
    * @param label
    * @description Function to send email ,label and id to server
    */
  deleteLabels(id, label, email) {
    let deleteNoteLabel = new FormData();
    deleteNoteLabel.append("id", id)
    deleteNoteLabel.append("label", label)
    deleteNoteLabel.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlDeleteNoteLabel, deleteNoteLabel, otheroption)
  }
}
