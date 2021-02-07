import {TestBed} from "@angular/core/testing";
import {HttpClientTestingModule, HttpTestingController} from "@angular/common/http/testing";
import {StatisticsService} from "./statistics.service";
import {MissionStatistics} from "../mission-statistics";
import DoneCallback = jest.DoneCallback;

describe('StatisticsService', () => {
  let service: StatisticsService;
  let httpTestingController: HttpTestingController;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule]
    });
    httpTestingController = TestBed.inject(HttpTestingController);
    service = TestBed.inject(StatisticsService);
  });

  it('retrieves mission statistics', (done: DoneCallback) => {
    const data = {failed: 5, succeeded: 2, civilianKilled: 0, missingInAction: 1} as MissionStatistics;
    service.missionStatistics().subscribe((stats: MissionStatistics) => {
      expect(stats).toBe(data);
      done();
    });

    httpTestingController.expectOne({method: 'GET', url: '/api/matches/statistics'}).flush(data);
  });
});
