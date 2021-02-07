import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StatisticsComponent } from './statistics.component';



@NgModule({
    declarations: [StatisticsComponent],
    exports: [
        StatisticsComponent
    ],
    imports: [
        CommonModule
    ]
})
export class StatisticsModule { }
