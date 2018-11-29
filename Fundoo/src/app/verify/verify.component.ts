import { Component, OnInit } from '@angular/core';
import { NgxSpinnerService } from 'ngx-spinner';
import { FormControl, FormGroupDirective, NgForm, Validators } from '@angular/forms';
import { ErrorStateMatcher } from '@angular/material/core';
import { DataService } from "../service/data.service";
@Component({
  selector: 'app-verify',
  templateUrl: './verify.component.html',
  styleUrls: ['./verify.component.css']
})
export class VerifyComponent implements OnInit {

  constructor(private data: DataService, private spinner: NgxSpinnerService) { }
  /**
  * @method ngOnInit()
  * @return void
  * @description Function to fetch data
  */
  ngOnInit() {
    this.spinner.show();
    let obs = this.data.verifyemail();
    obs.subscribe(
      (res: any) => {
        if (res.message == "200") {
          alert("email id is verified");
          this.spinner.hide();
        } else {
          alert("Email is not verified");
          this.spinner.hide();
        }
      });
  }

}
