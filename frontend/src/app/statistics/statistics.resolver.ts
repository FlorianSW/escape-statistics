import {ActivatedRouteSnapshot, Resolve, RouterStateSnapshot} from "@angular/router";
import {Observable} from "rxjs";
import {MissionStatistics} from "../mission-statistics";
import {Injectable} from "@angular/core";
import {StatisticsService} from "./statistics.service";

@Injectable({
  providedIn: "root"
})
export class StatisticsResolver implements Resolve<MissionStatistics> {
  constructor(private service: StatisticsService) {
  }

  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<MissionStatistics> {
    return this.service.missionStatistics();
  }
}
