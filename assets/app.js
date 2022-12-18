/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './javascript/countdown';

// start the Stimulus application
import './bootstrap';

import logoPath from './images/pont-chaban-black.svg';
import headerImgPath from './images/pont-chaban-header.jpg';


let html = `<img src="${logoPath}" alt="logo">`;
let html1 = `<img src="${headerImgPath}" alt="pont-chaban">`;