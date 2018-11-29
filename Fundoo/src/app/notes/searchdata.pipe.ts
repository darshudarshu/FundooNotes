import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'searchdata'
})
export class SearchdataPipe implements PipeTransform {

/**
 * @method transform 
 * @description fucntion to define custom filter 
 * @param value data within data to search
 * @param args data to be searched 
 */
  transform(value: any, args?: any): any {
    if (!args) return value;
    return value.filter(items => {
      return (
        items.notes.includes(args) == true || items.title.includes(args) == true
      );
    });
  }

}
