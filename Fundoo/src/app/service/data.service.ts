import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from '@angular/router';
import { serviceUrl } from '../serviceUrl/serviceUrl';
@Injectable({
  providedIn: "root"
})
export class DataService {
 /**
  * Api urls this.serviceurl.host + this.serviceurl.mainLabelLabelData
  */
  // private urlRegister = "http://localhost/codeigniter/registration";
  // private urlLogin = "http://localhost/codeigniter/login";
  // private urlForgot = "http://localhost/codeigniter/forgotPassword";
  // private urlReset = "http://localhost/codeigniter/resetPassword";
  // private urlGetEmail = "http://localhost/codeigniter/getEmailId";
  // private urlVerifyEmail = "http://localhost/codeigniter/veryfyEmailId";


  constructor(private http: HttpClient, private route: ActivatedRoute, private serviceurl: serviceUrl) { }
  /**
    * @method UserLoginData() 
    * @return observable data
    * @param login 
    * @description Function to send login data to server
    */
  UserLoginData(login) {
    let userLoginData = new FormData();
    userLoginData.append("email", login.email)
    userLoginData.append("password", login.pass)
    return this.http.post(this.serviceurl.host + this.serviceurl.login, userLoginData)
  }
  /**
    * @method UserRegistrationData() 
    * @return observable data
    * @param register
    * @description Function to send register data to server
    */
  UserRegistrationData(register) {
    let userRegisterData = new FormData();
    userRegisterData.append("username", register.name)
    userRegisterData.append("email", register.email)
    userRegisterData.append("mobilenumber", register.number)
    userRegisterData.append("password", register.pass)
    return this.http.post(this.serviceurl.host + this.serviceurl.register, userRegisterData)
  }
  /**
    * @method userPasswordRecoveryData() 
    * @return observable data
    * @param forgot 
    * @description Function to send forgot to server
    */
  userPasswordRecoveryData(forgot) {
    let userPassRecoveryData = new FormData();
    userPassRecoveryData.append("email", forgot.email)
    return this.http.post(this.serviceurl.host + this.serviceurl.forgot, userPassRecoveryData)
  }
  /**
    * @method UserResetData() 
    * @return observable data
    * @param reset 
    * @description Function to send reset data to server
    */

  UserResetData(reset) {
    let userResetData = new FormData();
    userResetData.append("token", this.route.snapshot.queryParamMap.get('token'));
    userResetData.append("pass", reset.pass)
    return this.http.post(this.serviceurl.host + this.serviceurl.reset, userResetData)
  }
  /**
    * @method getEmail() 
    * @return observable data
    * @param reset
    * @description Function to send get email from server
    */
  getEmail(reset) {
    let urlTocken = new FormData();
    urlTocken.append("token", this.route.snapshot.queryParamMap.get('token'));
    return this.http.post(this.serviceurl.host + this.serviceurl.getEmail, urlTocken)
  }
  /**
    * @method verifyemail() 
    * @return observable data
    * @description Function to send verify  email 
    */
  verifyemail() {
    let verifyEmailId = new FormData();
    verifyEmailId.append("token", this.route.snapshot.queryParamMap.get('token'));
    return this.http.post(this.serviceurl.host + this.serviceurl.verifyEmail, verifyEmailId)
  }
  /**
    * @method loggedIn() 
    * @return boolean
    * @description Function to check the token 
    */
  loggedIn() {
    return !!localStorage.getItem('token');
  }
  /**
    * @method getToken() 
    * @return string
    * @description Function to get the token
    */
  getToken() {
    return localStorage.getItem('token');
  }
  /**
    * @method socialLoginData() 
    * @return observable data
    * @param login 
    * @description Function to send login data to server
    */
  socialLoginData(email,name){
    debugger;
    // console.log(' sdfasfasdfsa',value[0].email);
    
    let socialLoginData = new FormData();
    socialLoginData.append("email",email);
    socialLoginData.append("name", name)
    return this.http.post(this.serviceurl.host + this.serviceurl.socialLoginData , socialLoginData)  
  }
}
