
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { MatIconRegistry } from "@angular/material/icon";
import { DomSanitizer } from "@angular/platform-browser";
import { LabelService } from "../service/label.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { CommonService } from '../service/common.service';
import { CommonlabelService } from '../service/commonlabel.service';
import { ImageService } from '../service/image.service';
import { Router } from "@angular/router";
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LabelsComponent } from './../labels/labels.component';
@Component({
  selector: 'app-fundoo-notes',
  templateUrl: './fundoo-notes.component.html',
  styleUrls: ['./fundoo-notes.component.css']
})
export class FundooNotesComponent {
  /**
   * var to hold image base64url
   */
  public base64textString;
  /**
  * variable to to store token email 
  */
  public val;
  /**
   * variable to to store email 
   */
  public email;
  public data = false;
  /**
   * variable to to store current labels 
   */
  public currentLabel = "";
  /**
   * variable to to store labels 
   */
  labels;
  /**
   * variable to to store url 
   */
  url = '';
  myurl = "";
  varr = false;
  ispresent;
  constructor(private image:ImageService, private commonlabelService: CommonlabelService, private labelservice: LabelService, private _cookieService: CookieService, private router: Router, private commonService: CommonService, public dialog: MatDialog) { }
  /**
    * @method ngOnInit() 
    * @return void
    * @description Function to fetch the data from source
    */
  ngOnInit() {
    this.email = this._cookieService.get('email');
    let obs = this.labelservice.fetchLabels(this.email);
    obs.subscribe(
      (res: any) => {
        this.labels = res;
      });
    let obss = this.image.fetchProfile(this.email);
    obss.subscribe(
      (res: any) => {
        if (res.profilepic != "") {
          this.ispresent = true;
          // this.myurl = res.profilepic;
          // console.log(this.myurl);

        }
        else {
          this.ispresent = false;
        }
      });
    /**
     * get the email present in the cookies
     */
    this.val = this._cookieService.get('email');
  }
  /**
   * @method sendMessage()
   * @return void 
   * @description function to send data to service 
   */
  sendMessage() {
    /**
     * assigning toggle functioning    
     */
    this.data = !this.data;
    /**
     * sending data to commonservice notifyOther method
     * @param data  
     */
    this.commonService.notifyOther(this.data);
  }
  /**
   * @var searchData 
   */
  searchData;
  /**
 * @method sendMessage()
 * @return void 
 * @description function to send data to service 
 */
  sendSearchData() {

    /**
     * sending data to commonservice notifyOther method
     * @param searchData  
     */
    this.commonService.sendSearchDataToService(this.searchData);
  }
  /**
   * @method logout()
   * @return void
   * @description function to remove the user account once he choosed to logged out
   */
  logout() {
    /**
     *remove the token present in the localstorage with key name token  
     */
    localStorage.removeItem("token");
    /**
     *using the router navigate to the login page with router link name login
     */
    this.router.navigate(['/login'])
  }
  openDialog(): void {
    const dialogRef = this.dialog.open(LabelsComponent, {
      data: { user: "yrtyyt" }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result != undefined) {

        this.labels = result;
      }
    });
  }
  /**
    * @method sendLabelName() 
    * @return void
    * @description Function to send LabelName
    */
  sendLabelName(selectedLabel) {
    /**
     * sending data to commonservice notifyOther method
     * @param selectedLabel  
     */
    this.commonlabelService.notifyLabel(selectedLabel);
  }


  /**
    * @method onSelectFile() 
    * @return void
    * @description Function to upload profile pic
    */
  //   onSelectFile(event) {
  //    debugger;
  //     if (event.target.files && event.target.files[0]) {
  //       var reader = new FileReader();
  //       // this.url = event.target.files[0];
  //       var file = event.target.files[0];
  //       console.log(file);
  //       // "{"name":"download (1).jpeg","type":"image\/jpeg","tmp_name":"\/tmp\/phpcG1W7w","error":0,"size":5917}"
  //       // console.log(file['name']);
  //       reader.readAsDataURL(event.target.files[0]); // read file as data url
  //       reader.onload = (event) => { // called once readAsDataURL is completed
  //         this.url = event.target.result;

  //         console.log("darshu");
  //         console.log(this.url);

  //         let obss = this.labelservice.saveProfile(this.url, this.email,file);
  //         obss.subscribe(
  //           (res: any) => {
  //            console.log("darshu");

  //             console.log(res);
  //                reader.readAsDataURL(res); // read file as data url
  //       reader.onload = (event) => { // called once readAsDataURL is completed
  //         this.myurl = event.target.result;
  //             this.myurl= JSON.parse(res);
  //             console.log(this.myurl);
  //             // alert(this.myurl);
  //              }   });
  //     }
  //   }
  // }




  onSelectFile(event) {
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
    this.base64textString = btoa(binaryString);
    console.log(binaryString));
    console.log(this.base64textString);
    
let obss = this.image.saveProfile(this.base64textString,this.email);
obss.subscribe(
  (res: any) => {
    if (res.profilepic != "") {
      this.ispresent = true;
      // this.myurl = res.profilepic;
      // console.log(this.myurl);

    }
    else {
      this.ispresent = false;
    }
  });

  }
  





}
