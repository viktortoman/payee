import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {MinMaxDate} from '../interfaces/min-max-date.model';
import {Interest} from '../interfaces/interest.model';
import {CreateInterest, formatCreateInterest} from '../interfaces/create-interest.model';

@Injectable({
    providedIn: 'root'
})
export class InterestService {

    private apiUrl = 'http://localhost:8000/api/interest';

    constructor(private http: HttpClient) {}

    getAll(): Observable<Interest[]> {
        return this.http.get<Interest[]>(this.apiUrl);
    }

    getMinAndMaxDates(): Observable<MinMaxDate> {
        return this.http.get<MinMaxDate>(`${this.apiUrl}/get-min-max-dates`);
    }

    calculate(interestData: CreateInterest): Observable<Interest>{
        const formattedData = formatCreateInterest(interestData);
        return this.http.post<Interest>(`${this.apiUrl}/calculate`, formattedData);
    }
}
