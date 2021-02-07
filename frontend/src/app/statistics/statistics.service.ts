import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {MissionStatistics} from "../mission-statistics";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class StatisticsService {
  constructor(private httpClient: HttpClient) {
  }

  missionStatistics(): Observable<MissionStatistics> {
    return this.httpClient.get<MissionStatistics>('/api/matches/statistics');
  }
}
