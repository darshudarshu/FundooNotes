import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: 'root'
})
export class LabelService {

 
  constructor(private http: HttpClient, private serviceurl: serviceUrl) { }
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
    return this.http.post(this.serviceurl.host + this.serviceurl.mainLabelLabelData, labelData)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.mainLabelChangeLabel, changeLabel)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.mainLabelDeleteLabel , deleteLabelData)
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
    return this.http.post(this.serviceurl.host + this.serviceurl.mainLabelFetchLabelData, fetchLabelsss)
  }

}
