import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from '@angular/common/http';
import { serviceUrl } from '../serviceUrl/serviceUrl';

@Injectable({
  providedIn: 'root'
})
export class ImageService {

  constructor(private http: HttpClient, private serviceurl: serviceUrl) { }

  /**
    * @method fetchProfile() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  fetchProfile(email) {
    let fetchImage = new FormData();
    fetchImage.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.profileFetchImage, fetchImage)
  }
  /**
    * @method saveProfile() 
    * @return observable data
    * @param email 
    * @param file 
    * @description Function to send email and url to server
    */
  saveProfile(url, email) {
    let saveImage = new FormData();
    saveImage.append("url", url)
    saveImage.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.profileSaveImage, saveImage)
  }
  /**
    * @method noteSaveImage() 
    * @return observable data
    * @param email 
    * @param url 
    * @description Function to send email and url to server
    */
  noteSaveImage(url, email, noteId) {
    debugger;
    let saveImage = new FormData();
    saveImage.append("url", url)
    saveImage.append("email", email)
    saveImage.append("id", noteId)
    return this.http.post(this.serviceurl.host + this.serviceurl.notesSaveImage, saveImage)
  }
  /**
    * @method notesFetchImage() 
    * @return observable data
    * @param email 
    * @description Function to send email and url to server
    */
  notesFetchImage(email) {
    let noteFetchImage = new FormData();
    noteFetchImage.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.notesFetchImage, noteFetchImage)
  }
  /**
    * @method fetchUserEmailId() 
    * @return observable data
    * @description Function to send email and url to server
    */
  fetchUserEmailId(email) {
    let emailData = new FormData();
    emailData.append("email", email)
    return this.http.post(this.serviceurl.host + this.serviceurl.fetchUserEmail,emailData)
  }
}
