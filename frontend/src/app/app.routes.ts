import {Routes} from '@angular/router';
import {InterestFormComponent} from './components/interest-form/interest-form.component';
import {InterestTableComponent} from "./components/interest-table/interest-table.component";

export const routes: Routes = [
    {
        path: '',
        component: InterestFormComponent
    },
    {
        path: 'results',
        component: InterestTableComponent
    }
];
