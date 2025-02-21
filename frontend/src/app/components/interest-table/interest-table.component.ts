import {Component} from '@angular/core';
import {Button, ButtonLabel} from 'primeng/button';
import {ReactiveFormsModule} from '@angular/forms';
import {InterestService} from '../../services/interest.service';
import {Interest} from '../../interfaces/interest.model';
import {TableModule} from 'primeng/table';
import {Router} from '@angular/router';
import {ProgressSpinner} from 'primeng/progressspinner';
import {CommonModule} from '@angular/common';

@Component({
    selector: 'app-interest-table',
    imports: [
        ReactiveFormsModule,
        TableModule,
        Button,
        ButtonLabel,
        ProgressSpinner,
        CommonModule
    ],
    templateUrl: './interest-table.component.html',
    styleUrl: './interest-table.component.css'
})
export class InterestTableComponent {
    loaded = false;
    data: Interest[] = [];

    constructor(
        private interestService: InterestService,
        private router: Router
    ) {
        this.interestService.getAll().subscribe((data: Interest[]) => {
            this.data = data;
            this.loaded = true;
        });
    }

    back(): void {
        this.router.navigate(['/']);
    }

    formatNumber(amount: number): string {
        return new Intl.NumberFormat('hu-HU', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    }
}
