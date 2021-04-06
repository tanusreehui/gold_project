import {backgroundColor} from 'html2canvas/dist/types/css/property-descriptors/background-color';
import {fontFamily} from 'html2canvas/dist/types/css/property-descriptors/font-family';
import {fontWeight} from 'html2canvas/dist/types/css/property-descriptors/font-weight';

let x;
if (window.location.origin === 'http://localhost:4200'){
  x = 'http://127.0.0.1';
  // console.log(x);
}else{
  x = window.location.origin;
}

export const GlobalVariable = Object.freeze({
  // local
  // BASE_API_URL: 'http://127.0.0.1:8000/api',

  // build
  // BASE_API_URL: 'http://127.0.0.1/gold_project/new_gold_api/public/api',
  // BASE_API_URL: window.location.origin + '/gold_project/new_gold_api/public/api',
  BASE_API_URL: x + '/gold_project/new_gold_api/public/api',
  BASE_API_URL_profile: x + '/gold_project/new_gold_api/public/',

  // ... more of your variables
});
