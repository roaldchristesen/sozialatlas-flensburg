SELECT
    json_build_object(
        'district_id', d.id,
        'district_name', d.name,
        'district_detail', json_object_agg(
            rd.year, json_build_object(
                'residents', rd.residents,
                'births', bd.births,
                'birth_rate', bd.birth_rate,
                'age_ratio', ard.quotient,
                'age_groups', json_build_object(
                    'age_18_to_under_30', agrd.age_18_to_under_30,
                    'age_30_to_under_45', agrd.age_30_to_under_45,
                    'age_45_to_under_65', agrd.age_45_to_under_65,
                    'age_65_to_under_80', agrd.age_65_to_under_80,
                    'age_0_to_under_7', agrd.age_0_to_under_7,
                    'age_60_and_above', agrd.age_60_and_above,
                    'age_80_and_above', agrd.age_80_and_above,
                    'age_to_under_18', cad.residents,
                    'age_18_to_under_65', ra1865d.residents,
                    'age_65_and_above', ra65ad.residents
                ),
                'employed_residents', epid.residents,
                'employment_rate', epid.employment_rate,
                'unemployed_residents', ued.residents,
                'unemployment_characteristics', json_build_object(
                    'percentage_sgb_iii', uecd.percentage_sgb_iii,
                    'percentage_sgb_ii', uecd.percentage_sgb_ii,
                    'percentage_foreign_citizenship', uecd.percentage_foreign_citizenship,
                    'percentage_female', uecd.percentage_female,
                    'percentage_age_under_25', uecd.percentage_age_under_25
                ),
                'housing_benefit', hbd.residents,
                'housing_assistance', json_build_object(
                    'notices_of_rent_arrears', hacd.notices_of_rent_arrears,
                    'termination_rent_arrears', hacd.termination_rent_arrears,
                    'termination_for_conduct', hacd.termination_for_conduct,
                    'action_for_eviction', hacd.action_for_eviction,
                    'eviction_notice', hacd.eviction_notice,
                    'eviction_carried', hacd.eviction_carried
                ),
                'risk_of_homelessness', hrhd.residents,
                'benefits_age_15_to_under_65', json_build_object(
                    'employable_with_benefits', ba1565d.employable_with_benefits,
                    'unemployment_benefits', ba1565d.unemployment_benefits,
                    'basic_income', ba1565d.basic_income,
                    'assisting_benefits', ba1565d.assisting_benefits
                ),
                'benefits_characteristics', json_build_object(
                    'beneficiaries_sgbii', bfd.residents,
                    'unemployability', bcd.unemployability,
                    'employability', bcd.employability,
                    'percentage_females', bcd.percentage_females,
                    'percentage_single_parents', bcd.percentage_single_parents,
                    'percentage_foreign_citizenship', bcd.percentage_foreign_citizenship
                ),
                'inactive_beneficiaries_in_households', iad.residents,
                'basic_benefits_income', json_build_object(
                    'male', bbid.male,
                    'female', bbid.female,
                    'age_18_to_under_65', bbid.age_18_to_under_65,
                    'age_65_and_above', bbid.age_65_and_above
                ),
                'migration_background', json_build_object(
                    'foreign_citizenship', mbd.foreign_citizenship,
                    'german_citizenship', mbd.german_citizenship
                )
            )
        )
    ) AS data_by_year_and_district
FROM
    districts AS d
LEFT JOIN
    residents_by_districts AS rd
    ON d.id = rd.district_id
LEFT JOIN
    births_by_districts AS bd
    ON d.id = bd.district_id
    AND bd.year = rd.year
LEFT JOIN
    age_ratio_by_districts AS ard
    ON d.id = ard.district_id
    AND ard.year = rd.year
LEFT JOIN
    children_age_under_18_by_districts AS cad
    ON d.id = cad.district_id
    AND cad.year = rd.year
LEFT JOIN
    age_groups_of_residents_by_districts AS agrd
    ON d.id = agrd.district_id
    AND agrd.year = rd.year
LEFT JOIN
    residents_age_18_to_under_65_by_districts AS ra1865d
    ON d.id = ra1865d.district_id
    AND rd.year = ra1865d.year
LEFT JOIN
    residents_age_65_and_above_by_districts AS ra65ad
    ON d.id = ra65ad.district_id
    AND ra65ad.year = rd.year
LEFT JOIN
    migration_background_by_districts AS mbd
    ON d.id = mbd.district_id
    AND mbd.year = rd.year
LEFT JOIN
    employed_with_pension_insurance_by_districts AS epid
    ON d.id = epid.district_id
    AND rd.year = epid.year
LEFT JOIN
    unemployed_residents_by_districts AS ued
    ON d.id = ued.district_id
    AND rd.year = ued.year
LEFT JOIN
    unemployed_residents_by_districts_categorized AS uecd
    ON d.id = uecd.district_id
    AND rd.year = uecd.year
LEFT JOIN
    housing_benefit_by_districts AS hbd
    ON d.id = hbd.district_id
    AND rd.year = hbd.year
LEFT JOIN
    housing_assistance_cases_by_districts AS hacd
    ON d.id = hacd.district_id
    AND rd.year = hacd.year
LEFT JOIN
    households_at_risk_of_homelessness_by_districts AS hrhd
    ON d.id = hrhd.district_id
    AND rd.year = hrhd.year
LEFT JOIN
    beneficiaries_age_15_to_under_65_by_districts AS ba1565d
    ON d.id = ba1565d.district_id
    AND rd.year = ba1565d.year
LEFT JOIN
    beneficiaries_by_districts AS bfd
    ON d.id = bfd.district_id
    AND rd.year = bfd.year
LEFT JOIN
    beneficiaries_characteristics_by_districts AS bcd
    ON d.id = bcd.district_id
    AND rd.year = bcd.year
LEFT JOIN
    inactive_beneficiaries_in_households_by_districts AS iad
    ON d.id = iad.district_id
    AND rd.year = iad.year
LEFT JOIN
    basic_benefits_income_by_districts AS bbid
    ON d.id = bbid.district_id
    AND rd.year = bbid.year
WHERE rd.year = 2021
GROUP BY
    d.id, rd.year
ORDER BY
    d.id, rd.year