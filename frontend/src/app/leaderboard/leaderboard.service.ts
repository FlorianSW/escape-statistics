import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {MissionLeaderboard} from "../mission-leaderboard";

@Injectable({
  providedIn: 'root'
})
export class LeaderboardService {
  constructor(private httpClient: HttpClient) {
  }

  missionLeaderboard(): Observable<MissionLeaderboard> {
    return this.httpClient.get<MissionLeaderboard>('/api/matches/leaderboard');
  }
}
