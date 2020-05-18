import { trigger, transition, style, animate } from '@angular/animations';

export const inOut = trigger('inOut', [
    transition(':enter', [
        style({ opacity: 0 }),
        animate('0.3s', style({ opacity: 1 }))
    ]),
    transition(':leave', [
        style({ opacity: 1 }),
        animate('0.3s', style({ height: 0, opacity: 0 }))
    ])
]);
export const stretch = trigger('inOut', [
    transition(':enter', [
        style({ width: 0 }),
        animate('0.3s', style({ width: '*' }))
    ]),
    transition(':leave', [
        style({ width: '*' }),
        animate('0.3s', style({ width: 0 }))
    ])
]);
export const opacity = trigger('opacity', [
    transition(':enter', [
        style({ opacity: 0 }),
        animate('0.3s', style({ opacity: 1 }))
    ]),
    transition(':leave', [
        style({ opacity: 1 }),
        animate('0.3s', style({ opacity: 0 }))
    ])
]);