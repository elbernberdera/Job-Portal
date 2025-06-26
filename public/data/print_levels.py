import csv

with open('psgc.csv', encoding='utf-8-sig') as f:
    reader = csv.DictReader(f)
    levels = set()
    for row in reader:
        levels.add(row['Geographic Level'].strip())
    print(levels)