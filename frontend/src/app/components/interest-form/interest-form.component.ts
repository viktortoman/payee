import {Component} from '@angular/core';
import {DatePickerModule} from 'primeng/datepicker';
import {FormBuilder, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Router} from '@angular/router';
import {InterestService} from '../../services/interest.service';
import {Button, ButtonDirective, ButtonLabel} from 'primeng/button';
import {CommonModule} from '@angular/common';
import {MinMaxDate} from '../../interfaces/min-max-date.model';
import {ProgressSpinner} from 'primeng/progressspinner';
import { InputNumberModule } from 'primeng/inputnumber';

@Component({
    selector: 'app-interest-form',
    imports: [
        DatePickerModule,
        ReactiveFormsModule,
        ButtonDirective,
        CommonModule,
        ButtonLabel,
        Button,
        ProgressSpinner,
        InputNumberModule
    ],
    templateUrl: './interest-form.component.html',
    styleUrl: './interest-form.component.css'
})
export class InterestFormComponent {
    loaded = false;
    interestForm: FormGroup = new FormGroup({});
    minDate?: Date;
    maxDate?: Date;
    errorMessage: string | null = null;

    constructor(
        private fb: FormBuilder,
        private interestService: InterestService,
        private router: Router
    ) {
        this.interestService.getMinAndMaxDates().subscribe((data: MinMaxDate) => {
            this.minDate = data.min ? new Date(data.min) : new Date();
            this.maxDate = data.max ? new Date(data.max) : new Date;

            this.interestForm = this.fb.group({
                start_date: [this.minDate, Validators.required],
                end_date: [this.maxDate, Validators.required],
                amount: [1000000, [Validators.required, Validators.min(1)]]
            });

            this.loaded = true;
        });
    }

    getErrorMessage(field: string): string {
        if (this.interestForm.get(field)?.hasError('required')) {
            return 'This field is required';
        }

        if (this.interestForm.get(field)?.hasError('min')) {
            return 'Value must be greater than 0';
        }

        return '';
    }

    showAll(): void {
        this.router.navigate(['/results']);
    }

    submit(): void {
        if (this.interestForm.valid) {
            this.errorMessage = null;
            this.loaded = false;

            this.interestService.calculate(this.interestForm.value).subscribe({
                next: () => this.router.navigate(['/results']),
                error: () => {
                    this.loaded = true;
                    this.errorMessage = 'An error occurred while processing your request. Please try again later.';
                }
            });
        } else {
            this.interestForm.markAllAsTouched();
            this.errorMessage = 'Please fill out all required fields.';
        }
    }
}
