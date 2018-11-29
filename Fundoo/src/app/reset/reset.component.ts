import { Component, OnInit } from "@angular/core";
import {
  FormControl,
  FormGroupDirective,
  NgForm,
  Validators
} from "@angular/forms";
import { ErrorStateMatcher } from "@angular/material/core";
import { DataService } from "../service/data.service";
@Component({
  selector: "app-reset",
  templateUrl: "./reset.component.html",
  styleUrls: ["./reset.component.css"]
})
export class ResetComponent implements OnInit {
  model: any = {};
  public value = "";
  public session = "";
  constructor(private data: DataService) { }
  /**
  * @method ngOnInit()
  * @return void
  * @description Function to fetch data
  */
  ngOnInit() {
    let obs = this.data.getEmail(this.model);
    obs.subscribe(
      (res: any) => {
        this.value = res.key;
        this.session = res.session;
      });
  }

  pass = new FormControl("", [Validators.required]);
  /**
  * @method getPassErrorMessage()
  * @return void
  * @description Function to error validation
  */
  getPassErrorMessage() {
    return this.pass.hasError("required")
      ? "You must enter password"
      : "enter 6 digit password";
  }
  /**
  * @method reset()
  * @return void
  * @description Function to reset the user password
  */
  reset() {
    let obs = this.data.UserResetData(this.model);
    obs.subscribe(
      (res: any) => {
        if (res.message == "200") {
          alert("reset successfull")
        } else {
          alert("reset unsuccessfull")
        }
      });
  }

}
