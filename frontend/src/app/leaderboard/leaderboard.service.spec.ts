import {TestBed} from "@angular/core/testing";
import {HttpClientTestingModule, HttpTestingController} from "@angular/common/http/testing";
import {LeaderboardService} from "./leaderboard.service";
import {MissionStatistics} from "../mission-statistics";
import DoneCallback = jest.DoneCallback;
import {MissionLeaderboard} from "../mission-leaderboard";

describe('LeaderboardService', () => {
  let service: LeaderboardService;
  let httpTestingController: HttpTestingController;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule]
    });
    httpTestingController = TestBed.inject(HttpTestingController);
    service = TestBed.inject(LeaderboardService);
  });

  it('retrieves mission leaderboard', (done: DoneCallback) => {
    const data = {shortestEscape: {island: 'Altis'}, longestEscape: {island: 'Chernarus'}} as MissionLeaderboard;
    service.missionLeaderboard().subscribe((stats: MissionLeaderboard) => {
      expect(stats).toBe(data);
      done();
    });

    httpTestingController.expectOne({method: 'GET', url: '/api/matches/leaderboard'}).flush(data);
  });
});
