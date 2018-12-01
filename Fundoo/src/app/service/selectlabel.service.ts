import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: 'root'
})
export class SelectlabelService {

constructor(private http: HttpClient, private serviceurl: serviceUrl) { }

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
    return this.http.post(this.serviceurl.host + this.serviceurl.labelFetchLabelNote, fetchData)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.labelChangeLabelDateTime, DataTime)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.labelCreateLabelNotes, notesData);

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
    return this.http.post(this.serviceurl.host + this.serviceurl.labelDeleteLabelNote, remainderId)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.labelDeleteNoteLabel, deleteNoteLabel)
  }
}
