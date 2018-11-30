import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class LabelService {
  private urlLabelData = "http://localhost/codeigniter/addLabel";
  private urlFetchLabelData = "http://localhost/codeigniter/saveLabels";
  private urlchangeLabel = "http://localhost/codeigniter/changeLabel";
  private urldeleteLabel = "http://localhost/codeigniter/deleteLabel";
  private urlfetchImage = "http://localhost/codeigniter/fetchImage";
  private urlsaveImage = "http://localhost/codeigniter/saveImage";
  constructor(private http: HttpClient) { }
  /**
    * @method addLabels() 
    * @return observable data
    * @param email 
    * @param label 
    * @description Function to send email and label to server
    */
  addLabels(label, email) {
    
    let labelData = new FormData();
    labelData.append("label", label)
    labelData.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlLabelData, labelData, otheroption)
  }
  /**
    * @method changeLabels() 
    * @return observable data
    * @param email 
    * @param id 
    * @param name 
    * @description Function to send name,email and id to server
    */
  changeLabels(id, name, email) {
    
    let changeLabel = new FormData();
    changeLabel.append("id", id)
    changeLabel.append("name", name)
    changeLabel.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlchangeLabel, changeLabel, otheroption)
  }
  /**
    * @method deleteLabels() 
    * @return observable data
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  deleteLabels(id, email) {
    let deleteLabelData = new FormData();
    deleteLabelData.append("id", id)
    deleteLabelData.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urldeleteLabel, deleteLabelData, otheroption)
  }
  /**
    * @method fetchLabels() 
    * @return observable data
    * @param email 
    * @description Function to send email  to server
    */
  fetchLabels(email) {
    let fetchLabelsss = new FormData();
    fetchLabelsss.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlFetchLabelData, fetchLabelsss, otheroption)
  }
  /**
    * @method fetchProfile() 
    * @return observable data
    * @param email 
    * @description Function to send email to server
    */
  fetchProfile(email) {
    let fetchImage = new FormData();
    fetchImage.append("email", email)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlfetchImage, fetchImage, otheroption)
  }
  /**
    * @method saveProfile() 
    * @return observable data
    * @param email 
    * @param url 
    * @description Function to send email and url to server
    */
  saveProfile(url, email,imagefile) {
    let saveImage = new FormData();
    saveImage.append("url", url)
    saveImage.append("email", email)
    // saveImage.append("file", imagefile , imagefile.tmp_name )
    saveImage.append("file", imagefile)
    let otheroption: any = {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
    return this.http.post(this.urlsaveImage, saveImage, otheroption)
  }
}
