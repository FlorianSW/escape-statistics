import {ComponentFixture, TestBed} from '@angular/core/testing';

import {StatisticsComponent} from './statistics.component';
import {StatisticsModule} from "./statistics.module";
import {ActivatedRoute, Data} from "@angular/router";
import {Subject} from "rxjs";
import {MissionStatistics} from "../mission-statistics";

describe('StatisticsComponent', () => {
  let fixture: ComponentFixture<StatisticsComponent>;
  let dataSubject: Subject<Data>;

  beforeEach(() => {
    dataSubject = new Subject<Data>();
    TestBed.configureTestingModule({
      imports: [StatisticsModule],
      providers: [{
        provide: ActivatedRoute,
        useValue: {
          data: dataSubject.asObservable()
        } as Partial<ActivatedRoute>
      }]
    }).compileComponents();

    fixture = TestBed.createComponent(StatisticsComponent);
    dataSubject.next({
      missionStatistics: {
        missingInAction: 1,
        civilianKilled: 1,
        succeeded: 5,
        failed: 7,
      } as MissionStatistics
    })
    fixture.detectChanges();
  });

  it('shows total number of sessions', () => {
    expect(fixture.nativeElement.textContent).toContain(14);
  });
});
