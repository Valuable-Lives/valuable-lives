<?php

namespace Database\Seeders;

use App\Models\EnslavedMatch;
use App\Models\EnslavedRecord;
use App\Models\EnslaverMatch;
use App\Models\EnslaverRecord;
use App\Models\Entry;
use App\Models\EntryEvolution;
use App\Models\GlossaryTerm;
use App\Models\Holding;
use App\Models\HoldingEstateLink;
use App\Models\HoldingMatch;
use App\Models\IncDecEnslaver;
use App\Models\IncreaseDecrease;
use App\Models\Individual;
use App\Models\Parish;
use App\Models\RecordAnnotation;
use App\Models\RecordRelationship;
use App\Models\Relationship;
use App\Models\RelationshipType;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    private const REGISTER_YEARS = ['1817', '1820', '1823', '1826', '1829', '1832'];

    private const PARISHES = [
        'Port Royal', 'Kingston', 'St Andrew', 'St Thomas in the East',
        'Portland', 'St Mary', 'St Ann', 'Trelawny', 'St James',
        'Hanover', 'Westmoreland', 'St Elizabeth', 'Manchester',
        'Clarendon', 'Vere', 'St Dorothy', 'St John', 'St Catherine',
        'St Thomas in the Vale', 'Metcalfe',
    ];

    private const GIVEN_NAMES_MALE = [
        'Adam', 'Abraham', 'Andrew', 'Benjamin', 'Caesar', 'Charles',
        'Cudjoe', 'Daniel', 'David', 'Edward', 'Francis', 'George',
        'Harry', 'Henry', 'Isaac', 'Jack', 'Jacob', 'James', 'Joe',
        'John', 'Jupiter', 'Lewis', 'Moses', 'Neptune', 'Patrick',
        'Peter', 'Prince', 'Quaco', 'Quashie', 'Robert', 'Sam',
        'Simon', 'Thomas', 'Tom', 'Will', 'William', 'York',
        'Primus', 'Scipio', 'Hector', 'Nero', 'Plato', 'Pompey',
    ];

    private const GIVEN_NAMES_FEMALE = [
        'Abigail', 'Amelia', 'Ann', 'Betty', 'Bridget', 'Catherine',
        'Charlotte', 'Clarissa', 'Cuba', 'Diana', 'Dolly', 'Eleanor',
        'Elizabeth', 'Esther', 'Eve', 'Flora', 'Frances', 'Grace',
        'Hannah', 'Harriet', 'Jane', 'Jenny', 'Juba', 'Judy',
        'Kitty', 'Lucy', 'Maria', 'Martha', 'Mary', 'Mimba',
        'Molly', 'Nancy', 'Phibba', 'Patience', 'Peggy', 'Rachel',
        'Rebecca', 'Rose', 'Ruth', 'Sally', 'Sarah', 'Susannah',
    ];

    private const HOLDING_NAMES = [
        'Springfield', 'Mount Pleasant', 'Prospect', 'Hope',
        'Friendship', 'Content', 'Retreat', 'Rose Hall', 'Good Hope',
        'Orange Valley', 'Green Park', 'Windsor', 'Belvidere',
        'Harmony Hall', 'Paradise', 'Golden Grove', 'Blue Mountain',
        'Richmond', 'Albion', 'Unity', 'Success', 'Industry',
        'Endeavour', 'Providence', 'Liberty Hall', 'Nonsuch',
        'Bushy Park', 'Cherry Garden', 'Papine', 'Temple Hall',
        'Cambridge', 'Oxford', 'Hampton Court', 'Llandovery',
        'Montpelier', 'Arcadia', 'Belmont', 'Caledonia',
        'Dundee', 'Edinburgh', 'Glasgow', 'Inverness',
        'Kellits', 'Lluidas Vale', 'New Forest', 'Pimento Grove',
        'Salt Savannah', 'Swanswick', 'Tryall', 'Whitehall',
    ];

    private const ENSLAVER_SURNAMES = [
        'Barrett', 'Beckford', 'Bryan', 'Campbell', 'Clarke',
        'Dawkins', 'Douglas', 'Edwards', 'Ellis', 'Foster',
        'Gordon', 'Graham', 'Grant', 'Hamilton', 'Harris',
        'Hibbert', 'Jackson', 'Johnson', 'Jones', 'Kelly',
        'Lewis', 'Long', 'Malcolm', 'Martin', 'Mitchell',
        'Morgan', 'Palmer', 'Price', 'Reid', 'Robertson',
        'Scott', 'Simpson', 'Smith', 'Stewart', 'Taylor',
        'Thompson', 'Tharp', 'Vassall', 'Walker', 'Williams',
    ];

    private const ENSLAVER_GIVEN_NAMES = [
        'Alexander', 'Andrew', 'Charles', 'Daniel', 'Edward',
        'Francis', 'George', 'Henry', 'James', 'John',
        'Matthew', 'Nathaniel', 'Patrick', 'Peter', 'Richard',
        'Robert', 'Samuel', 'Thomas', 'William', 'David',
    ];

    private const CAPACITIES = [
        'Owner', 'Executor', 'Overseer', 'Agent', 'Attorney',
        'Mortgagee', 'Trustee', 'Guardian', 'Receiver', 'Administrator',
    ];

    private const HOLDING_TYPES = ['plantation', 'pen', 'jobbing_gang', 'urban_household', 'other'];
    private const SIZE_CATEGORIES = ['under_10', '10_49', '50_99', '100_plus'];
    private const COLOURS = ['Black', 'Brown', 'Mulatto', 'Sambo', 'Quadroon', 'Mustee'];
    private const AFRICAN_NATIONS = ['Ibo', 'Congo', 'Coromantee', 'Mandingo', 'Moco', 'Nago', 'Papaw', 'Chamba', 'Eboe'];

    private const INC_DEC_TYPES = [
        'increase' => ['Born', 'Purchased', 'Received by bequest', 'Transferred in'],
        'decrease' => ['Died', 'Sold', 'Manumitted', 'Run away', 'Transported', 'Executed'],
    ];

    private const GLOSSARY = [
        ['Creole', 'A person born in Jamaica, as opposed to Africa. In the registers, "Creole" indicates Jamaican birth regardless of racial category.', ['Jamaica-born'], 'Register terminology'],
        ['Manumission', 'The formal act of freeing an enslaved person. Could be granted by the enslaver during their lifetime, by will after death, or purchased by the enslaved person or a third party.', ['freed', 'emancipated'], 'Legal'],
        ['Colour', 'Racial classification assigned by the enslaver in the register. Categories included Black, Brown, Mulatto, Sambo, Quadroon, and Mustee, reflecting a hierarchical system of racial categorisation.', ['race', 'racial category'], 'Register terminology'],
        ['Increase', 'A register entry recording additions to the enslaved population of a holding: births, purchases, or transfers in.', [], 'Register terminology'],
        ['Decrease', 'A register entry recording reductions in the enslaved population: deaths, sales, manumissions, runaways, or transfers out.', [], 'Register terminology'],
        ['Pen', 'A livestock farm, typically smaller than a plantation. Pens raised cattle, horses, and mules, often supplying neighbouring plantations.', [], 'Geographic'],
        ['Jobbing gang', 'A group of enslaved people hired out to work on various properties rather than being attached to a single estate. Often owned by a single enslaver who contracted their labour.', [], 'Geographic'],
        ['T71', 'The National Archives (UK) series reference for the Jamaican slave registers. Each volume covers a specific parish and register period.', ['TNA reference'], 'Register terminology'],
        ['Apprenticeship', 'The transitional system (1834-1838) following the Slavery Abolition Act, in which formerly enslaved people were required to continue working for their former enslavers as "apprentices" before full emancipation.', [], 'Historical'],
        ['Compensation', 'The £20 million paid by the British government to slave-owners (not the enslaved) following the 1833 Abolition Act. Records of these payments form the basis of the LBS database.', [], 'Historical'],
    ];

    private int $ancestryId = 1000;

    public function run(): void
    {
        $this->command->info('Seeding parishes...');
        $parishes = $this->seedParishes();

        $this->command->info('Seeding relationship types...');
        $this->seedRelationshipTypes();

        $this->command->info('Seeding glossary terms...');
        $this->seedGlossary();

        $this->command->info('Seeding holdings and entries...');
        $holdings = $this->seedHoldingsAndEntries($parishes);

        $this->command->info('Seeding individuals, enslaved records, and matches...');
        $individuals = $this->seedIndividualsAndRecords($holdings);

        $this->command->info('Seeding relationships...');
        $this->seedRelationships($individuals);

        $this->command->info('Seeding record annotations...');
        $this->seedAnnotations($individuals, $holdings);

        $this->command->info('Done. Seeded:');
        $this->command->table(
            ['Entity', 'Count'],
            [
                ['Parishes', Parish::count()],
                ['Holdings', Holding::count()],
                ['Entries', Entry::count()],
                ['Enslaved records', EnslavedRecord::count()],
                ['Enslaver records', EnslaverRecord::count()],
                ['Increase/decreases', IncreaseDecrease::count()],
                ['Inc/dec enslavers', IncDecEnslaver::count()],
                ['Record relationships', RecordRelationship::count()],
                ['Individuals', Individual::count()],
                ['Enslaved matches', EnslavedMatch::count()],
                ['Enslaver matches', EnslaverMatch::count()],
                ['Holding matches', HoldingMatch::count()],
                ['Holding-estate links', HoldingEstateLink::count()],
                ['Relationships', Relationship::count()],
                ['Glossary terms', GlossaryTerm::count()],
                ['Annotations', RecordAnnotation::count()],
            ],
        );
    }

    private function seedParishes(): array
    {
        return array_map(fn ($name) => Parish::create(['name' => $name]), self::PARISHES);
    }

    private function seedRelationshipTypes(): void
    {
        foreach ([
            ['Mother', 'Child'], ['Father', 'Child'], ['Sibling', 'Sibling'],
            ['Grandmother', 'Grandchild'], ['Grandfather', 'Grandchild'],
            ['Aunt', 'Niece/Nephew'], ['Uncle', 'Niece/Nephew'], ['Spouse', 'Spouse'],
        ] as [$name, $inverse]) {
            RelationshipType::create(['name' => $name, 'inverse_name' => $inverse]);
        }
    }

    private function seedGlossary(): void
    {
        foreach (self::GLOSSARY as [$term, $definition, $aliases, $category]) {
            GlossaryTerm::create([
                'term' => $term,
                'definition' => $definition,
                'aliases' => $aliases ?: null,
                'category' => $category,
            ]);
        }
    }

    private function seedHoldingsAndEntries(array $parishes): array
    {
        $holdings = [];
        $namePool = self::HOLDING_NAMES;
        shuffle($namePool);

        foreach (array_slice($namePool, 0, 50) as $name) {
            $parish = $parishes[array_rand($parishes)];
            $sizeCategory = self::SIZE_CATEGORIES[array_rand(self::SIZE_CATEGORIES)];

            $holding = Holding::create([
                'name' => $name,
                'parish_id' => $parish->id,
                'type' => self::HOLDING_TYPES[array_rand(self::HOLDING_TYPES)],
                'size_category' => $sizeCategory,
                'latitude' => 17.9 + (mt_rand(0, 1000) / 10000),
                'longitude' => -76.8 + (mt_rand(0, 2000) / 10000),
                'quality_flag' => $this->weightedRandom(['okay' => 70, 'probs' => 20, 'bigprobs' => 8, 'gone' => 2]),
            ]);

            // Determine register year range
            $startIdx = mt_rand(0, 2);
            $endIdx = mt_rand(max($startIdx + 2, 4), 5);
            $years = array_slice(self::REGISTER_YEARS, $startIdx, $endIdx - $startIdx + 1);

            $basePopulation = match ($sizeCategory) {
                'under_10' => mt_rand(2, 9),
                '10_49' => mt_rand(10, 49),
                '50_99' => mt_rand(50, 99),
                '100_plus' => mt_rand(100, 350),
            };

            $entries = [];
            foreach ($years as $year) {
                $total = max(1, $basePopulation + mt_rand(-10, 10));
                $male = (int) round($total * (mt_rand(40, 55) / 100));
                $female = $total - $male;
                $tnaRef = 'T71/' . mt_rand(30, 300);
                $tnaPage = mt_rand(1, 400);

                $entry = Entry::create([
                    'unique_identifier' => $this->ancestryId++,
                    'original_order' => mt_rand(1, 500),
                    'tna_ref' => $tnaRef,
                    'registers_page_number' => $tnaPage,
                    'register_year' => $year,
                    'parish_id' => $parish->id,
                    'previous_total_males' => $year === $years[0] ? null : mt_rand(0, $male),
                    'previous_total_females' => $year === $years[0] ? null : mt_rand(0, $female),
                    'total_last_return' => $year === $years[0] ? null : max(0, $total + mt_rand(-5, 5)),
                    'this_return_total_males' => $male,
                    'this_return_total_females' => $female,
                    'total_this_return' => $total,
                    'number_increase' => mt_rand(0, 5),
                    'number_decrease' => mt_rand(0, 5),
                    'entry_text' => $this->randomEntryText($name),
                    'estate_name' => $name,
                ]);

                // Link entry to holding via HoldingMatch
                HoldingMatch::create([
                    'entry_id' => $entry->id,
                    'holding_id' => $holding->id,
                    'match_rating' => mt_rand(80, 100),
                    'match_type' => 'automatic',
                    'match_date' => now(),
                ]);

                // Create enslaver records for this entry
                $numEnslavers = mt_rand(1, 3);
                for ($e = 0; $e < $numEnslavers; $e++) {
                    $sex = mt_rand(0, 85) < 80 ? 'male' : 'female';
                    $givenNames = $sex === 'male' ? self::ENSLAVER_GIVEN_NAMES : ['Ann', 'Elizabeth', 'Mary', 'Sarah', 'Jane', 'Catherine'];
                    $givenName = $givenNames[array_rand($givenNames)];
                    $surname = self::ENSLAVER_SURNAMES[array_rand(self::ENSLAVER_SURNAMES)];
                    $capacity = self::CAPACITIES[array_rand(self::CAPACITIES)];

                    EnslaverRecord::create([
                        'unique_identifier' => $this->ancestryId++,
                        'tna_ref' => $tnaRef,
                        'registers_page_number' => $tnaPage,
                        'register_year' => $year,
                        'parish_id' => $parish->id,
                        'entry_id' => $entry->id,
                        'enslaver_name_full' => "$givenName $surname",
                        'enslaver_given_name' => $givenName,
                        'enslaver_surname' => $surname,
                        'enslaver_gender' => $sex === 'male' ? 'Male' : 'Female',
                        'enslaver_capacity' => $capacity,
                        'enslaver_signed' => mt_rand(0, 1) === 1,
                    ]);
                }

                $entries[] = ['model' => $entry, 'total' => $total, 'male' => $male, 'female' => $female];
                $basePopulation = $total;
            }

            $holdings[] = [
                'model' => $holding,
                'parish' => $parish,
                'years' => $years,
                'entries' => $entries,
            ];
        }

        return $holdings;
    }

    private function seedIndividualsAndRecords(array $holdings): array
    {
        $individuals = [];

        foreach ($holdings as $h) {
            $holding = $h['model'];
            $parish = $h['parish'];
            $years = $h['years'];
            $entries = $h['entries'];

            $firstEntry = $entries[0];
            $count = min($firstEntry['total'], 20);

            for ($i = 0; $i < $count; $i++) {
                $sex = mt_rand(0, 1) === 0 ? 'male' : 'female';
                $givenNames = $sex === 'male' ? self::GIVEN_NAMES_MALE : self::GIVEN_NAMES_FEMALE;
                $givenName = $givenNames[array_rand($givenNames)];
                $surname = mt_rand(0, 100) < 15 ? self::ENSLAVER_SURNAMES[array_rand(self::ENSLAVER_SURNAMES)] : null;
                $birthplace = $this->weightedRandom(['creole' => 65, 'african' => 35]);
                $colour = self::COLOURS[array_rand(self::COLOURS)];
                $firstYearInt = (int) $years[0];
                $estimatedBirthYear = $firstYearInt - mt_rand(1, 60);
                $deathYear = mt_rand(0, 100) < 20 ? min($estimatedBirthYear + mt_rand(5, 70), 1838) : null;

                // Create master individual
                $individual = Individual::create([
                    'given_name' => $givenName,
                    'surname' => $surname,
                    'sex' => $sex,
                    'colour' => $colour,
                    'birthplace' => $birthplace,
                    'country_nation' => $birthplace === 'african' ? self::AFRICAN_NATIONS[array_rand(self::AFRICAN_NATIONS)] : null,
                    'estimated_birth_year' => $estimatedBirthYear,
                    'death_year' => $deathYear,
                    'appearance' => mt_rand(0, 100) < 10 ? $this->randomAppearance() : null,
                ]);

                // Create enslaved records for each register year and match them
                $disappearIdx = ($deathYear && $deathYear <= (int) end($years))
                    ? $this->yearIndex($deathYear)
                    : count($entries);

                foreach ($entries as $idx => $entryData) {
                    if ($idx >= $disappearIdx) break;

                    $year = $years[$idx];
                    $age = (int) $year - $estimatedBirthYear;
                    if ($age < 0) continue;

                    $fullName = $surname ? "$givenName $surname" : $givenName;
                    $tnaRef = $entryData['model']->tna_ref;

                    $enslavedRecord = EnslavedRecord::create([
                        'unique_identifier' => $this->ancestryId++,
                        'tna_ref' => $tnaRef,
                        'registers_page_number' => $entryData['model']->registers_page_number,
                        'register_year' => $year,
                        'parish_id' => $parish->id,
                        'entry_id' => $entryData['model']->id,
                        'enslaved_name_full' => $fullName,
                        'enslaved_given_name' => $givenName,
                        'enslaved_surname' => $surname,
                        'birthplace' => $birthplace === 'african' ? 'African' : 'Creole',
                        'gender' => $sex === 'male' ? 'Male' : 'Female',
                        'colour' => $colour,
                        'age_years' => $age,
                        'occupation' => mt_rand(0, 100) < 8 ? $this->randomOccupation() : null,
                    ]);

                    // Match to individual
                    EnslavedMatch::create([
                        'enslaved_record_id' => $enslavedRecord->id,
                        'individual_id' => $individual->id,
                        'match_rating' => mt_rand(85, 100),
                        'match_type' => $this->weightedRandom(['automatic' => 60, 'checked' => 30, 'manual' => 10]),
                        'match_date' => now(),
                    ]);

                    // Increase/decrease events (10% chance)
                    if (mt_rand(0, 100) < 10) {
                        $incDec = $this->weightedRandom(['increase' => 40, 'decrease' => 60]);
                        $types = self::INC_DEC_TYPES[$incDec];
                        $type = $types[array_rand($types)];

                        $event = IncreaseDecrease::create([
                            'enslaved_record_id' => $enslavedRecord->id,
                            'increase_or_decrease' => $incDec,
                            'full_text' => "$type since last return",
                            'type' => $type,
                            'year' => (int) $year,
                        ]);

                        // 50% chance of associated enslaver
                        if (mt_rand(0, 1) === 1) {
                            $eSurname = self::ENSLAVER_SURNAMES[array_rand(self::ENSLAVER_SURNAMES)];
                            $eGiven = self::ENSLAVER_GIVEN_NAMES[array_rand(self::ENSLAVER_GIVEN_NAMES)];
                            IncDecEnslaver::create([
                                'increase_decrease_id' => $event->id,
                                'enslaver_full_name' => "$eGiven $eSurname",
                                'enslaver_given_name' => $eGiven,
                                'enslaver_surname' => $eSurname,
                            ]);
                        }
                    }
                }

                $individuals[] = ['model' => $individual, 'holding_id' => $holding->id];
            }
        }

        // Create enslaver individuals and match them to enslaver records
        $enslaverRecords = EnslaverRecord::inRandomOrder()->limit(50)->get();
        foreach ($enslaverRecords as $record) {
            $individual = Individual::create([
                'prefix' => mt_rand(0, 1) ? 'Mr' : null,
                'given_name' => $record->enslaver_given_name,
                'surname' => $record->enslaver_surname,
                'sex' => strtolower($record->enslaver_gender ?? 'unknown'),
            ]);

            EnslaverMatch::create([
                'enslaver_record_id' => $record->id,
                'individual_id' => $individual->id,
                'match_rating' => mt_rand(80, 100),
                'match_type' => 'automatic',
                'match_date' => now(),
            ]);
        }

        return $individuals;
    }

    private function seedRelationships(array $individuals): void
    {
        $motherType = RelationshipType::where('name', 'Mother')->first();
        $siblingType = RelationshipType::where('name', 'Sibling')->first();
        if (!$motherType || !$siblingType) return;

        // Group by holding
        $byHolding = [];
        foreach ($individuals as $ind) {
            $byHolding[$ind['holding_id']][] = $ind['model'];
        }

        foreach ($byHolding as $group) {
            $females = array_values(array_filter($group, fn ($i) => $i->sex === 'female' && ($i->estimated_birth_year ?? 1800) < 1810));
            $children = array_values(array_filter($group, fn ($i) => ($i->estimated_birth_year ?? 1800) >= 1810));

            if (empty($females) || empty($children)) continue;

            $motherChildren = [];
            foreach ($children as $child) {
                $mother = $females[array_rand($females)];
                $ageDiff = ($child->estimated_birth_year ?? 1820) - ($mother->estimated_birth_year ?? 1790);
                if ($ageDiff < 14) continue;

                Relationship::create([
                    'person1_id' => $mother->id,
                    'person2_id' => $child->id,
                    'relationship_type_id' => $motherType->id,
                    'source' => 'registers',
                    'confidence' => 'confirmed',
                ]);

                // Also create a raw record relationship
                $motherRecords = EnslavedMatch::where('individual_id', $mother->id)->pluck('enslaved_record_id');
                $childRecords = EnslavedMatch::where('individual_id', $child->id)->pluck('enslaved_record_id');
                if ($motherRecords->isNotEmpty() && $childRecords->isNotEmpty()) {
                    RecordRelationship::create([
                        'enslaved_record_id' => $childRecords->first(),
                        'relation_record_id' => $motherRecords->first(),
                        'relationship_full_text' => "Child of {$mother->given_name}",
                        'relation_to' => 'Child',
                        'relation_from' => 'Mother',
                        'relation_given_name' => $mother->given_name,
                        'relation_surname' => $mother->surname,
                    ]);
                }

                $motherChildren[$mother->id][] = $child;
            }

            foreach ($motherChildren as $siblings) {
                for ($i = 0; $i < count($siblings) - 1; $i++) {
                    for ($j = $i + 1; $j < count($siblings); $j++) {
                        Relationship::create([
                            'person1_id' => $siblings[$i]->id,
                            'person2_id' => $siblings[$j]->id,
                            'relationship_type_id' => $siblingType->id,
                            'source' => 'inferred',
                            'confidence' => 'probable',
                        ]);
                    }
                }
            }
        }
    }

    private function seedAnnotations(array $individuals, array $holdings): void
    {
        foreach (array_slice($individuals, 0, 3) as $ind) {
            RecordAnnotation::create([
                'annotatable_type' => Individual::class,
                'annotatable_id' => $ind['model']->id,
                'title' => 'Research note',
                'content_html' => '<p>This individual may be referenced in the Jamaica Almanack under a variant spelling. Further verification needed against TNA originals.</p>',
            ]);
        }

        foreach (array_slice($holdings, 0, 2) as $h) {
            RecordAnnotation::create([
                'annotatable_type' => Holding::class,
                'annotatable_id' => $h['model']->id,
                'title' => 'Historical context',
                'content_html' => '<p>This holding appears in contemporary maps of the parish. The estate was later subject to a compensation claim (see LBS database).</p>',
            ]);
        }
    }

    // --- Helpers ---

    private function weightedRandom(array $weights): string
    {
        $total = array_sum($weights);
        $roll = mt_rand(1, $total);
        $cumulative = 0;
        foreach ($weights as $value => $weight) {
            $cumulative += $weight;
            if ($roll <= $cumulative) return (string) $value;
        }
        return (string) array_key_first($weights);
    }

    private function yearIndex(int $year): int
    {
        foreach (self::REGISTER_YEARS as $idx => $ry) {
            if ((int) $ry >= $year) return $idx;
        }
        return count(self::REGISTER_YEARS);
    }

    private function randomAppearance(): string
    {
        $d = ['Tall, country marks on both cheeks', 'Short stature, scar on left arm', 'Medium height, filed teeth', 'Tall, strong build', 'Country marks on forehead', 'Lame in right leg', 'Blind in one eye'];
        return $d[array_rand($d)];
    }

    private function randomOccupation(): string
    {
        $o = ['Field labourer', 'Domestic', 'Driver', 'Cooper', 'Carpenter', 'Mason', 'Boiler', 'Watchman', 'Cook', 'Washerwoman', 'Seamstress', 'Stock keeper', 'Carter'];
        return $o[array_rand($o)];
    }

    private function randomEntryText(string $estateName): string
    {
        $surname = self::ENSLAVER_SURNAMES[array_rand(self::ENSLAVER_SURNAMES)];
        $given = self::ENSLAVER_GIVEN_NAMES[array_rand(self::ENSLAVER_GIVEN_NAMES)];
        $capacity = self::CAPACITIES[array_rand(self::CAPACITIES)];
        return "A Return of Slaves belonging to $estateName in the possession of $given $surname as $capacity";
    }
}
