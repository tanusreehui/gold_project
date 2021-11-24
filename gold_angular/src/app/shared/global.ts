import {backgroundColor} from 'html2canvas/dist/types/css/property-descriptors/background-color';
import {fontFamily} from 'html2canvas/dist/types/css/property-descriptors/font-family';
import {fontWeight} from 'html2canvas/dist/types/css/property-descriptors/font-weight';
import {environment} from "../../environments/environment";

let x;
// if (window.location.origin === 'http://127.0.0.1:4200/#/'){
//   x = 'http://127.0.0.1';
//   console.log('url',x);
// }else{
//   x = window.location.origin;
//   console.log('url2',x);
// }

let project_url =window.location.origin;
let firstArray =  project_url.split("/");
let secondArray =  firstArray[2].split(":");
x = (firstArray[0]+"//"+secondArray[0]);
let ENV_BASE_API_URL = environment.BASE_API_URL;


export const GlobalVariable = Object.freeze({
  // BASE_API_URL: x + '/gold_project/new_gold_api/public/api',
  BASE_API_URL: x + ENV_BASE_API_URL,


  BASE_API_URL_profile: x + '/gold_project/new_gold_api/public/',



  // ... more of your variables
});
