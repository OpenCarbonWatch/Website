import pandas as pd

france = pd.read_csv('../data/OCW_France.csv', encoding='UTF-8', dtype=str)
france = france[france['type_id'].isin(['7220', '7229', '7230'])]
france = france.sort_values(by=['type_id', 'name'])
france = france.reset_index()
france = france.fillna('')

table_start = \
    """
        <div class="table-responsive">
          <table class="table table-sm text-nowrap">
            <thead>
              <tr>
                <th>Organization</th>
                <th>Identifier</th>
                <th>Last report</th>
                <th>Commitments</th>
                <th>Scope 3</th>
                <th>Files</th>
              </tr>
            </thead>
            <tbody>
    """
table_stop = \
    """
            </tbody>
          </table>
        </div>
    """

result = ''

last_type_id = '0000'
count = 0
for i in range(france.shape[0]):
    type_id = france.at[i, 'type_id']
    if type_id != last_type_id and i > 0:
        result += table_stop
    if type_id[0] != last_type_id[0]:
        result += '<h3>' + france.at[i, 'type_label_1'] + '</h3>'
    if type_id[:2] != last_type_id[:2]:
        result += '<h4>' + france.at[i, 'type_label_2'] + '</h4>'
    if type_id != last_type_id:
        result += '<h5>' + france.at[i, 'type_label_3'] + '</h5>'
        result += table_start
    last_type_id = type_id
    result += '<tr><td>' + france.at[i, 'name'] + '</td><td><span class="badge badge-light">' + france.at[i, 'id'] + ' / ' + france.at[i, 'city_id'] + '</span></td>'
    last_year = france.at[i, 'last_assessment']
    if last_year == '':
        result += '<td><span class="badge badge-pill badge-danger">None</span></td>'
        result += '<td></td>'
        result += '<td></td>'
        result += '<td></td>'
    else:
        is_private = france.at[i, 'is_private'] == 'True'
        year = int(last_year)
        danger = (is_private and year <= 2013) or ((not is_private) and year <= 2014)
        valid = (is_private and year >= 2015) or ((not is_private) and year >= 2016)
        if danger:
            result += '<td><span class="badge badge-pill badge-danger">' + last_year + '</span></td>'
        elif valid:
            result += '<td><span class="badge badge-pill badge-success">' + last_year + '</span></td>'
        else:
            result += '<td><span class="badge badge-pill badge-warning">' + last_year + '</span></td>'
        wa = 'Yes' if france.at[i, 'with_action_plan'] == 'True' else 'No'
        w3 = 'Yes' if france.at[i, 'with_scope_3'] == 'True' else 'No'
        result += '<td>' + wa + '</td>'
        result += '<td>' + w3 + '</td>'
        result += '<td>'
        links = france.at[i, 'links'].split("\n")
        if len(links) == 1:
            result += '<a href="' + links[0] + '">View report</a>'
        else:
            indexes = range(len(links))
            hrefs = ['<a href="' + links[i] + '">' + str(i + 1) + '</a>' for i in indexes]
            result += 'View report ' + ', '.join(hrefs)
        result += '</td>'
    result += '</tr>'

result += table_stop


with open('index_template.html', 'r', encoding='UTF-8') as file:
    template = file.read()
template = template.replace('{{ FRANCE }}', result)

with open('index.html', 'w', encoding='UTF-8') as file:
    file.write(template)

