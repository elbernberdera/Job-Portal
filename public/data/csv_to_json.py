import csv
import json

csv_file = 'psgc_fixed.csv'
json_file = 'ph-address.json'

regions = {}

with open(csv_file, encoding='utf-8-sig') as f:
    reader = csv.DictReader(f)
    for row in reader:
        code = row['10-digit PSGC'].strip()
        name = row['Name'].strip()
        level = row['Geographic Level'].strip()

        if not code or not name or not level:
            continue

        if level == 'Reg':
            if name not in regions:
                regions[name] = {'code': code, 'provinces': {}}
        elif level == 'Prov':
            region_code = code[:2]
            for rname, rdata in regions.items():
                if rdata['code'][:2] == region_code:
                    rdata['provinces'][name] = {'code': code, 'cities': {}}
                    break
        elif level in ['City', 'Mun']:
            region_code = code[:2]
            province_code = code[:4]
            city_code = code[:7]
            for rname, rdata in regions.items():
                if rdata['code'][:2] == region_code:
                    for pname, pdata in rdata['provinces'].items():
                        if pdata['code'][:4] == province_code:
                            pdata['cities'][name] = {'code': code, 'barangays': []}
                            break
        elif level == 'Bgy':
            region_code = code[:2]
            province_code = code[:4]
            city_code = code[:7]
            found = False
            for rname, rdata in regions.items():
                if rdata['code'][:2] == region_code:
                    for pname, pdata in rdata['provinces'].items():
                        if pdata['code'][:4] == province_code:
                            for cname, cdata in pdata['cities'].items():
                                if cdata['code'][:7] == city_code:
                                    cdata['barangays'].append(name)
                                    found = True
                                    break
                            if found:
                                break
                    if found:
                        break

# Convert to list for easier dropdown use
output = []
for rname, rdata in regions.items():
    region_obj = {'name': rname, 'provinces': []}
    for pname, pdata in rdata['provinces'].items():
        province_obj = {'name': pname, 'cities': []}
        for cname, cdata in pdata['cities'].items():
            city_obj = {'name': cname, 'barangays': cdata['barangays']}
            province_obj['cities'].append(city_obj)
        region_obj['provinces'].append(province_obj)
    output.append(region_obj)

with open(json_file, 'w', encoding='utf-8') as f:
    json.dump(output, f, ensure_ascii=False, indent=2)

print(f"JSON saved to {json_file}")