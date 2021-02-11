import {ComponentFixture, TestBed} from '@angular/core/testing';

import {StatisticsComponent} from './statistics.component';
import {StatisticsModule} from "./statistics.module";
import {of} from "rxjs";
import {MissionStatistics} from "../mission-statistics";
import {StatisticsService} from "./statistics.service";

describe('StatisticsComponent', () => {
  let fixture: ComponentFixture<StatisticsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [StatisticsModule],
      providers: [{
        provide: StatisticsService,
        useValue: {
          missionStatistics: jest.fn(() => {
            return of({
              missingInAction: 1,
              civilianKilled: 1,
              succeeded: 5,
              failed: 7,
            } as MissionStatistics)
          })
        } as Partial<StatisticsService>
      }]
    }).compileComponents();

    fixture = TestBed.createComponent(StatisticsComponent);
    fixture.detectChanges();
  });

  it('shows total number of sessions', () => {
    expect(fixture.nativeElement.textContent).toContain(14);
  });
});
