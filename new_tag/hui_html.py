class Table:
    classes=list()
    tbody_rows = list()
    thead_rows = list()
    
    def __init__(self,id='',classes=''):
        self.id=id
        if classes!='':
            self.classes.append(classes)
            
    def append_class(self,new_class):
        self.classes.append(new_class)
        
    def appen_row(self,row_content):
        self.tbody_rows.append(row_content)
    def appen_header_row(self,row_content):
        self.thead_rows.append(row_content)    
    def generate(self):
        temp_classes = ' '.join(self.classes)
        temp_thead_rows= ' '.join(self.thead_rows)
        temp_tbody_rows= ' '.join(self.tbody_rows)
        table_head = '<thead>%s</thead>' % (temp_thead_rows)
        table_body = '<tbody>%s</tbody>' % (temp_tbody_rows) 
        return '<table class="%s" >%s %s </table>' % (temp_classes,table_head, table_body)  