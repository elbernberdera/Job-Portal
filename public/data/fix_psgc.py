import csv
import os

input_file = 'psgc.csv'
output_file = 'psgc_fixed.csv'

print("Current directory:", os.getcwd())
print("Checking if input file exists:", os.path.exists(input_file))

if not os.path.exists(input_file):
    print("Input file not found!")
else:
    with open(input_file, encoding='utf-8-sig') as infile, open(output_file, 'w', newline='', encoding='utf-8') as outfile:
        reader = csv.DictReader(infile)
        fieldnames = reader.fieldnames
        print("Fieldnames found:", fieldnames)
        writer = csv.DictWriter(outfile, fieldnames=fieldnames)
        writer.writeheader()
        row_count = 0
        for row in reader:
            code = row['10-digit PSGC'].strip()
            try:
                if 'E' in code or 'e' in code:
                    code = str(int(float(code))).zfill(10)
                else:
                    code = code.zfill(10)
            except Exception as e:
                print("Error converting code:", code, e)
            row['10-digit PSGC'] = code
            writer.writerow(row)
            row_count += 1
        print("Rows processed:", row_count)
    print("Fixed CSV saved as", output_file)