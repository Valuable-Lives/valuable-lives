<?php

namespace Database\Seeders;

use App\Models\Enslaver;
use App\Models\EnslaverHolding;
use App\Models\GlossaryTerm;
use App\Models\Holding;
use App\Models\HoldingRegister;
use App\Models\Individual;
use App\Models\IndividualRegister;
use App\Models\LifeEvent;
use App\Models\Parish;
use App\Models\RecordAnnotation;
use App\Models\Relationship;
use App\Models\RelationshipType;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    private const REGISTER_YEARS = ['1817', '1820', '1823', '1826', '1829', '1832'];

    // Real Jamaican parishes from the register period
    private const PARISHES = [
        'Port Royal', 'Kingston', 'St Andrew', 'St Thomas in the East',
        'Portland', 'St Mary', 'St Ann', 'Trelawny', 'St James',
        'Hanover', 'Westmoreland', 'St Elizabeth', 'Manchester',
        'Clarendon', 'Vere', 'St Dorothy', 'St John', 'St Catherine',
        'St Thomas in the Vale', 'Metcalfe',
    ];

    // Period-appropriate given names for enslaved people
    private const GIVEN_NAMES_MALE = [
        'Adam', 'Abraham', 'Andrew', 'Benjamin', 'Caesar', 'Charles',
        'Cudjoe', 'Daniel', 'David', 'Edward', 'Francis', 'George',
        'Harry', 'Henry', 'Isaac', 'Jack', 'Jacob', 'James', 'Joe',
        'John', 'Jupiter', 'Lewis', 'Moses', 'Neptune', 'Patrick',
        'Peter', 'Prince', 'Quaco', 'Quashie', 'Robert', 'Sam',
        'Simon', 'Thomas', 'Tom', 'Will', 'William', 'York',
        'Primus', 'Scipio', 'Hector', 'Nero', 'Plato', 'Pompey',
        'Cato', 'Fortune', 'Glasgow', 'Dublin', 'Bristol', 'London',
    ];

    private const GIVEN_NAMES_FEMALE = [
        'Abigail', 'Amelia', 'Ann', 'Betty', 'Bridget', 'Catherine',
        'Charlotte', 'Clarissa', 'Cuba', 'Diana', 'Dolly', 'Eleanor',
        'Elizabeth', 'Esther', 'Eve', 'Flora', 'Frances', 'Grace',
        'Hannah', 'Harriet', 'Jane', 'Jenny', 'Juba', 'Judy',
        'Kitty', 'Letitia', 'Lucy', 'Maria', 'Martha', 'Mary',
        'Mimba', 'Molly', 'Nancy', 'Phibba', 'Patience', 'Peggy',
        'Quasheba', 'Rachel', 'Rebecca', 'Rose', 'Ruth', 'Sally',
        'Sarah', 'Susannah', 'Venus', 'Violet', 'Dido', 'Minerva',
    ];

    // Period-appropriate estate/holding names
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

    // Period-appropriate enslaver surnames
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
        'owner', 'executor', 'overseer', 'agent', 'attorney',
        'mortgagee', 'trustee', 'guardian', 'receiver', 'administrator',
    ];

    private const HOLDING_TYPES = ['plantation', 'pen', 'jobbing_gang', 'urban_household', 'other'];
    private const SIZE_CATEGORIES = ['under_10', '10_49', '50_99', '100_plus'];
    private const COLOURS = ['Black', 'Brown', 'Mulatto', 'Sambo', 'Quadroon', 'Mustee'];
    private const AFRICAN_NATIONS = ['Ibo', 'Congo', 'Coromantee', 'Mandingo', 'Moco', 'Nago', 'Papaw', 'Chamba', 'Eboe'];

    private const EVENT_TYPES = [
        'birth', 'death', 'purchase', 'sale', 'manumission',
        'runaway', 'transported', 'hired_out',
        'moved_within_parish', 'moved_between_parishes',
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

    public function run(): void
    {
        $this->command->info('Seeding parishes...');
        $parishes = $this->seedParishes();

        $this->command->info('Seeding relationship types...');
        $this->seedRelationshipTypes();

        $this->command->info('Seeding glossary terms...');
        $this->seedGlossary();

        $this->command->info('Seeding holdings...');
        $holdings = $this->seedHoldings($parishes);

        $this->command->info('Seeding enslavers...');
        $enslavers = $this->seedEnslavers($holdings);

        $this->command->info('Seeding individuals...');
        $individuals = $this->seedIndividuals($holdings);

        $this->command->info('Seeding life events...');
        $this->seedLifeEvents($individuals, $holdings);

        $this->command->info('Seeding relationships...');
        $this->seedRelationships($individuals, $holdings);

        $this->command->info('Seeding record annotations...');
        $this->seedAnnotations($individuals, $holdings);

        $this->command->info('Done. Seeded:');
        $this->command->table(
            ['Entity', 'Count'],
            [
                ['Parishes', Parish::count()],
                ['Holdings', Holding::count()],
                ['Holding registers', HoldingRegister::count()],
                ['Enslavers', Enslaver::count()],
                ['Enslaver-holding links', EnslaverHolding::count()],
                ['Individuals', Individual::count()],
                ['Individual registers', IndividualRegister::count()],
                ['Life events', LifeEvent::count()],
                ['Relationships', Relationship::count()],
                ['Glossary terms', GlossaryTerm::count()],
                ['Annotations', RecordAnnotation::count()],
            ],
        );
    }

    private function seedParishes(): array
    {
        $parishes = [];
        foreach (self::PARISHES as $name) {
            $parishes[] = Parish::create(['name' => $name]);
        }
        return $parishes;
    }

    private function seedRelationshipTypes(): void
    {
        $types = [
            ['Mother', 'Child'],
            ['Father', 'Child'],
            ['Sibling', 'Sibling'],
            ['Grandmother', 'Grandchild'],
            ['Grandfather', 'Grandchild'],
            ['Aunt', 'Niece/Nephew'],
            ['Uncle', 'Niece/Nephew'],
            ['Spouse', 'Spouse'],
        ];

        foreach ($types as [$name, $inverse]) {
            RelationshipType::create([
                'name' => $name,
                'inverse_name' => $inverse,
            ]);
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

    private function seedHoldings(array $parishes): array
    {
        $holdings = [];
        $namePool = self::HOLDING_NAMES;
        shuffle($namePool);

        // Create ~80 holdings spread across parishes
        foreach ($namePool as $i => $name) {
            if ($i >= 80) break;

            $parish = $parishes[array_rand($parishes)];
            $type = self::HOLDING_TYPES[array_rand(self::HOLDING_TYPES)];
            $sizeCategory = self::SIZE_CATEGORIES[array_rand(self::SIZE_CATEGORIES)];

            $holding = Holding::create([
                'name' => $name,
                'parish_id' => $parish->id,
                'type' => $type,
                'size_category' => $sizeCategory,
                'latitude' => 17.9 + (mt_rand(0, 1000) / 10000),
                'longitude' => -76.8 + (mt_rand(0, 2000) / 10000),
                'quality_flag' => $this->weightedRandom(['okay' => 70, 'probs' => 20, 'bigprobs' => 8, 'gone' => 2]),
            ]);

            // Determine which register years this holding appears in
            $startIdx = mt_rand(0, 2); // most holdings appear from early on
            $endIdx = mt_rand(max($startIdx + 2, 4), 5); // most survive to the end
            $years = array_slice(self::REGISTER_YEARS, $startIdx, $endIdx - $startIdx + 1);

            $basePopulation = match ($sizeCategory) {
                'under_10' => mt_rand(2, 9),
                '10_49' => mt_rand(10, 49),
                '50_99' => mt_rand(50, 99),
                '100_plus' => mt_rand(100, 350),
            };

            foreach ($years as $year) {
                // Population drifts slightly each year
                $total = max(1, $basePopulation + mt_rand(-10, 10));
                $male = (int) round($total * (mt_rand(40, 55) / 100));
                $female = $total - $male;
                $african = (int) round($total * (mt_rand(10, 50) / 100));
                $creole = $total - $african;

                HoldingRegister::create([
                    'holding_id' => $holding->id,
                    'register_year' => $year,
                    'enslaved_total' => $total,
                    'enslaved_male' => $male,
                    'enslaved_female' => $female,
                    'enslaved_african' => $african,
                    'enslaved_creole' => $creole,
                    'tna_reference' => 'T71/' . mt_rand(30, 300),
                    'tna_page' => mt_rand(1, 400),
                ]);

                $basePopulation = $total;
            }

            $holdings[] = ['model' => $holding, 'years' => $years];
        }

        return $holdings;
    }

    private function seedEnslavers(array $holdings): array
    {
        $enslavers = [];

        foreach ($holdings as $h) {
            $holding = $h['model'];
            $years = $h['years'];

            // 1-3 enslavers per holding across its lifetime
            $numEnslavers = mt_rand(1, 3);
            for ($e = 0; $e < $numEnslavers; $e++) {
                $sex = mt_rand(0, 85) < 80 ? 'male' : 'female';
                $givenNames = $sex === 'male' ? self::ENSLAVER_GIVEN_NAMES : ['Ann', 'Elizabeth', 'Mary', 'Sarah', 'Jane', 'Catherine', 'Margaret', 'Frances'];

                $enslaver = Enslaver::create([
                    'prefix' => $sex === 'female' ? $this->weightedRandom(['Mrs' => 50, 'Miss' => 30, '' => 20]) : $this->weightedRandom(['' => 60, 'Mr' => 30, 'Hon.' => 5, 'Rev.' => 5]),
                    'given_name' => $givenNames[array_rand($givenNames)],
                    'surname' => self::ENSLAVER_SURNAMES[array_rand(self::ENSLAVER_SURNAMES)],
                    'sex' => $sex,
                    'colour' => mt_rand(0, 95) < 90 ? null : 'Brown',
                    'status' => mt_rand(0, 95) < 90 ? 'Free' : 'Free person of colour',
                ]);

                // Assign to holding for a subset of years
                $capacity = self::CAPACITIES[array_rand(self::CAPACITIES)];
                $enslaverYears = ($e === 0) ? $years : array_slice($years, mt_rand(0, count($years) - 1));

                foreach ($enslaverYears as $year) {
                    EnslaverHolding::create([
                        'enslaver_id' => $enslaver->id,
                        'holding_id' => $holding->id,
                        'capacity' => $capacity,
                        'register_year' => $year,
                    ]);
                }

                $enslavers[] = $enslaver;
            }
        }

        return $enslavers;
    }

    private function seedIndividuals(array $holdings): array
    {
        $individuals = [];

        foreach ($holdings as $h) {
            $holding = $h['model'];
            $years = $h['years'];

            // Use the first year's population as a guide
            $firstRegister = HoldingRegister::where('holding_id', $holding->id)
                ->where('register_year', $years[0])
                ->first();

            $count = $firstRegister ? min($firstRegister->enslaved_total, 30) : mt_rand(3, 15);

            for ($i = 0; $i < $count; $i++) {
                $sex = mt_rand(0, 1) === 0 ? 'male' : 'female';
                $givenNames = $sex === 'male' ? self::GIVEN_NAMES_MALE : self::GIVEN_NAMES_FEMALE;
                $birthplace = $this->weightedRandom(['creole' => 65, 'african' => 35]);

                $firstYearInt = (int) $years[0];
                $estimatedBirthYear = $firstYearInt - mt_rand(1, 60);

                $individual = Individual::create([
                    'given_name' => $givenNames[array_rand($givenNames)],
                    'surname' => mt_rand(0, 100) < 15 ? self::ENSLAVER_SURNAMES[array_rand(self::ENSLAVER_SURNAMES)] : null,
                    'sex' => $sex,
                    'colour' => self::COLOURS[array_rand(self::COLOURS)],
                    'birthplace' => $birthplace,
                    'country_nation' => $birthplace === 'african' ? self::AFRICAN_NATIONS[array_rand(self::AFRICAN_NATIONS)] : null,
                    'estimated_birth_year' => $estimatedBirthYear,
                    'death_year' => mt_rand(0, 100) < 20 ? min($estimatedBirthYear + mt_rand(5, 70), 1838) : null,
                    'appearance' => mt_rand(0, 100) < 10 ? $this->randomAppearance() : null,
                ]);

                // Place individual in registers; they might disappear partway through
                $disappearIdx = ($individual->death_year && $individual->death_year <= (int) end($years))
                    ? $this->yearIndex($individual->death_year)
                    : count($years);

                foreach ($years as $idx => $year) {
                    if ($idx >= $disappearIdx) break;

                    $age = (int) $year - $estimatedBirthYear;
                    if ($age < 0) continue;

                    IndividualRegister::create([
                        'individual_id' => $individual->id,
                        'register_year' => $year,
                        'age' => $age,
                        'holding_id' => $holding->id,
                    ]);
                }

                $individuals[] = ['model' => $individual, 'holding' => $holding, 'years' => $years];
            }
        }

        return $individuals;
    }

    private function seedLifeEvents(array $individuals, array $holdings): void
    {
        foreach ($individuals as $ind) {
            $individual = $ind['model'];
            $holding = $ind['holding'];
            $years = $ind['years'];

            // Birth event
            if ($individual->estimated_birth_year >= 1817) {
                $birthYear = $this->closestRegisterYear($individual->estimated_birth_year);
                if ($birthYear && in_array($birthYear, $years)) {
                    LifeEvent::create([
                        'individual_id' => $individual->id,
                        'holding_id' => $holding->id,
                        'event_type' => 'birth',
                        'register_year' => $birthYear,
                    ]);
                }
            }

            // Death event
            if ($individual->death_year) {
                $deathYear = $this->closestRegisterYear($individual->death_year);
                if ($deathYear && in_array($deathYear, $years)) {
                    LifeEvent::create([
                        'individual_id' => $individual->id,
                        'holding_id' => $holding->id,
                        'event_type' => 'death',
                        'register_year' => $deathYear,
                    ]);
                }
            }

            // Random events (5% chance per individual)
            if (mt_rand(0, 100) < 5) {
                $eventType = $this->weightedRandom([
                    'runaway' => 25, 'manumission' => 20, 'sale' => 20,
                    'purchase' => 15, 'hired_out' => 10, 'moved_within_parish' => 10,
                ]);
                $year = $years[array_rand($years)];

                $destHolding = null;
                if (in_array($eventType, ['sale', 'purchase', 'moved_within_parish', 'moved_between_parishes'])) {
                    $randomHolding = $holdings[array_rand($holdings)];
                    $destHolding = $randomHolding['model']->id;
                }

                LifeEvent::create([
                    'individual_id' => $individual->id,
                    'holding_id' => $holding->id,
                    'event_type' => $eventType,
                    'register_year' => $year,
                    'origin_destination_holding_id' => $destHolding,
                ]);
            }
        }
    }

    private function seedRelationships(array $individuals, array $holdings): void
    {
        $motherType = RelationshipType::where('name', 'Mother')->first();
        $siblingType = RelationshipType::where('name', 'Sibling')->first();

        if (!$motherType || !$siblingType) return;

        // Group individuals by holding
        $byHolding = [];
        foreach ($individuals as $ind) {
            $holdingId = $ind['holding']->id;
            $byHolding[$holdingId][] = $ind['model'];
        }

        foreach ($byHolding as $group) {
            $females = array_filter($group, fn ($i) => $i->sex === 'female' && ($i->estimated_birth_year ?? 1800) < 1810);
            $children = array_filter($group, fn ($i) => ($i->estimated_birth_year ?? 1800) >= 1810);

            $females = array_values($females);
            $children = array_values($children);

            if (empty($females) || empty($children)) continue;

            // Assign children to mothers
            $motherChildren = [];
            foreach ($children as $child) {
                $mother = $females[array_rand($females)];

                // Check age plausibility (mother at least 14 years older)
                $ageDiff = ($child->estimated_birth_year ?? 1820) - ($mother->estimated_birth_year ?? 1790);
                if ($ageDiff < 14) continue;

                Relationship::create([
                    'person1_id' => $mother->id,
                    'person2_id' => $child->id,
                    'relationship_type_id' => $motherType->id,
                    'source' => 'registers',
                    'confidence' => 'confirmed',
                ]);

                $motherChildren[$mother->id][] = $child;
            }

            // Infer sibling relationships
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
        // Add a few sample annotations
        $sampleIndividuals = array_slice($individuals, 0, 3);
        foreach ($sampleIndividuals as $ind) {
            RecordAnnotation::create([
                'annotatable_type' => Individual::class,
                'annotatable_id' => $ind['model']->id,
                'title' => 'Research note',
                'content_html' => '<p>This individual may be referenced in the Jamaica Almanack under a variant spelling. Further verification needed against TNA originals.</p>',
            ]);
        }

        $sampleHoldings = array_slice($holdings, 0, 2);
        foreach ($sampleHoldings as $h) {
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
            if ($roll <= $cumulative) {
                return (string) $value;
            }
        }
        return (string) array_key_first($weights);
    }

    private function closestRegisterYear(int $year): ?string
    {
        $closest = null;
        $minDiff = PHP_INT_MAX;
        foreach (self::REGISTER_YEARS as $ry) {
            $diff = abs((int) $ry - $year);
            if ($diff < $minDiff) {
                $minDiff = $diff;
                $closest = $ry;
            }
        }
        return $closest;
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
        $descriptions = [
            'Tall, country marks on both cheeks',
            'Short stature, scar on left arm',
            'Medium height, filed teeth',
            'Tall, strong build',
            'Small, mark on right shoulder',
            'Country marks on forehead',
            'Lame in right leg',
            'Blind in one eye',
            'Branded on right breast',
        ];
        return $descriptions[array_rand($descriptions)];
    }
}
