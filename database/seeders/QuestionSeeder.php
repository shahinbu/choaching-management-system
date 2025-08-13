<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Topic;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $topics = Topic::with('subject')->get();
        
        if ($topics->isEmpty()) {
            $this->command->error('No topics found. Please run CourseSeeder first.');
            return;
        }

        $questions = $this->getQuestions();
        $questionCount = 0;
        
        foreach ($questions as $questionData) {
            if ($questionCount >= 100) break;
            
            // Get random topic or find by subject
            $topic = $topics->where('subject.name', $questionData['subject'])->first() ?? $topics->random();
            
            Question::create([
                'topic_id' => $topic->id,
                'partner_id' => 1,
                'question_text' => $questionData['question'],
                'option_a' => $questionData['options']['a'],
                'option_b' => $questionData['options']['b'],
                'option_c' => $questionData['options']['c'],
                'option_d' => $questionData['options']['d'],
                'correct_answer' => $questionData['correct'],
                'explanation' => $questionData['explanation'],
                'difficulty_level' => $questionData['difficulty'],
                'marks' => $questionData['marks'],
                'status' => 'active',
            ]);
            
            $questionCount++;
        }

        $this->command->info("Created {$questionCount} MCQ questions successfully!");
    }

    private function getQuestions(): array
    {
        return [
            // Physics Questions (20 questions)
            ['subject' => 'Physics', 'question' => 'What is the SI unit of force?', 'options' => ['a' => 'Newton', 'b' => 'Joule', 'c' => 'Watt', 'd' => 'Pascal'], 'correct' => 'a', 'explanation' => 'The SI unit of force is Newton (N).', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'The acceleration due to gravity on Earth is approximately:', 'options' => ['a' => '9.8 m/s²', 'b' => '10.8 m/s²', 'c' => '8.8 m/s²', 'd' => '11.8 m/s²'], 'correct' => 'a', 'explanation' => 'Standard gravity is 9.8 m/s².', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'What is the speed of light in vacuum?', 'options' => ['a' => '3 × 10⁸ m/s', 'b' => '3 × 10⁶ m/s', 'c' => '3 × 10⁷ m/s', 'd' => '3 × 10⁹ m/s'], 'correct' => 'a', 'explanation' => 'Speed of light is 3 × 10⁸ m/s.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'The formula for kinetic energy is:', 'options' => ['a' => '½mv²', 'b' => 'mv²', 'c' => '½m²v', 'd' => 'm²v²'], 'correct' => 'a', 'explanation' => 'KE = ½mv².', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'What type of wave is sound?', 'options' => ['a' => 'Transverse', 'b' => 'Longitudinal', 'c' => 'Electromagnetic', 'd' => 'Standing'], 'correct' => 'b', 'explanation' => 'Sound is a longitudinal wave.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'The unit of electric current is:', 'options' => ['a' => 'Volt', 'b' => 'Ampere', 'c' => 'Ohm', 'd' => 'Coulomb'], 'correct' => 'b', 'explanation' => 'Electric current is measured in Amperes.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'What is the unit of power?', 'options' => ['a' => 'Joule', 'b' => 'Watt', 'c' => 'Newton', 'd' => 'Pascal'], 'correct' => 'b', 'explanation' => 'Power is measured in Watts.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'The frequency of a wave is measured in:', 'options' => ['a' => 'Meters', 'b' => 'Seconds', 'c' => 'Hertz', 'd' => 'Joules'], 'correct' => 'c', 'explanation' => 'Frequency is measured in Hertz.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'Ohm\'s law states that V = IR. What does R represent?', 'options' => ['a' => 'Resistance', 'b' => 'Reactance', 'c' => 'Reluctance', 'd' => 'Resonance'], 'correct' => 'a', 'explanation' => 'R represents resistance.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'The principle of conservation of energy states that:', 'options' => ['a' => 'Energy can be created', 'b' => 'Energy can be destroyed', 'c' => 'Energy cannot be created or destroyed', 'd' => 'Energy always increases'], 'correct' => 'c', 'explanation' => 'Energy cannot be created or destroyed.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'What is the formula for calculating momentum?', 'options' => ['a' => 'p = mv', 'b' => 'p = ma', 'c' => 'p = mgh', 'd' => 'p = ½mv²'], 'correct' => 'a', 'explanation' => 'Momentum equals mass times velocity.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'Which law states that for every action, there is an equal and opposite reaction?', 'options' => ['a' => 'First Law', 'b' => 'Second Law', 'c' => 'Third Law', 'd' => 'Law of Gravitation'], 'correct' => 'c', 'explanation' => 'Newton\'s Third Law.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'The work done by a force is maximum when the angle is:', 'options' => ['a' => '0°', 'b' => '45°', 'c' => '90°', 'd' => '180°'], 'correct' => 'a', 'explanation' => 'Maximum work at 0° angle.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'What happens to resistance when temperature increases?', 'options' => ['a' => 'Increases', 'b' => 'Decreases', 'c' => 'Remains same', 'd' => 'Becomes zero'], 'correct' => 'a', 'explanation' => 'Resistance increases with temperature.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'The phenomenon of bending light is called:', 'options' => ['a' => 'Reflection', 'b' => 'Refraction', 'c' => 'Diffraction', 'd' => 'Interference'], 'correct' => 'b', 'explanation' => 'Bending of light is refraction.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'Total internal reflection occurs when light travels from:', 'options' => ['a' => 'Denser to rarer medium', 'b' => 'Rarer to denser medium', 'c' => 'Same medium', 'd' => 'Vacuum to air'], 'correct' => 'a', 'explanation' => 'From denser to rarer medium.', 'difficulty' => 3, 'marks' => 3],
            ['subject' => 'Physics', 'question' => 'The SI unit of electric charge is:', 'options' => ['a' => 'Ampere', 'b' => 'Coulomb', 'c' => 'Volt', 'd' => 'Ohm'], 'correct' => 'b', 'explanation' => 'Electric charge is measured in Coulombs.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Physics', 'question' => 'What is the relationship between frequency and wavelength?', 'options' => ['a' => 'Directly proportional', 'b' => 'Inversely proportional', 'c' => 'No relationship', 'd' => 'Exponential'], 'correct' => 'b', 'explanation' => 'Frequency and wavelength are inversely proportional.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'The unit of magnetic field strength is:', 'options' => ['a' => 'Tesla', 'b' => 'Weber', 'c' => 'Henry', 'd' => 'Gauss'], 'correct' => 'a', 'explanation' => 'Magnetic field is measured in Tesla.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Physics', 'question' => 'What is the escape velocity from Earth?', 'options' => ['a' => '11.2 km/s', 'b' => '9.8 km/s', 'c' => '7.9 km/s', 'd' => '15.5 km/s'], 'correct' => 'a', 'explanation' => 'Earth\'s escape velocity is 11.2 km/s.', 'difficulty' => 3, 'marks' => 3],

            // Chemistry Questions (20 questions)
            ['subject' => 'Chemistry', 'question' => 'What is the chemical symbol for gold?', 'options' => ['a' => 'Go', 'b' => 'Gd', 'c' => 'Au', 'd' => 'Ag'], 'correct' => 'c', 'explanation' => 'Gold symbol is Au from Latin aurum.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'The atomic number of carbon is:', 'options' => ['a' => '6', 'b' => '12', 'c' => '14', 'd' => '8'], 'correct' => 'a', 'explanation' => 'Carbon has 6 protons.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'Which gas is most abundant in Earth\'s atmosphere?', 'options' => ['a' => 'Oxygen', 'b' => 'Carbon dioxide', 'c' => 'Nitrogen', 'd' => 'Argon'], 'correct' => 'c', 'explanation' => 'Nitrogen is 78% of atmosphere.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'What is the pH of pure water at 25°C?', 'options' => ['a' => '6', 'b' => '7', 'c' => '8', 'd' => '9'], 'correct' => 'b', 'explanation' => 'Pure water has pH 7.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'The molecular formula of methane is:', 'options' => ['a' => 'CH₄', 'b' => 'C₂H₆', 'c' => 'C₃H₈', 'd' => 'CH₂'], 'correct' => 'a', 'explanation' => 'Methane is CH₄.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'What type of bond exists in NaCl?', 'options' => ['a' => 'Covalent', 'b' => 'Ionic', 'c' => 'Metallic', 'd' => 'Hydrogen'], 'correct' => 'b', 'explanation' => 'NaCl has ionic bonds.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'Which element has the highest electronegativity?', 'options' => ['a' => 'Oxygen', 'b' => 'Fluorine', 'c' => 'Chlorine', 'd' => 'Nitrogen'], 'correct' => 'b', 'explanation' => 'Fluorine has highest electronegativity.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'The process of solid changing to gas is:', 'options' => ['a' => 'Melting', 'b' => 'Evaporation', 'c' => 'Sublimation', 'd' => 'Condensation'], 'correct' => 'c', 'explanation' => 'Solid to gas is sublimation.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'Which is a noble gas?', 'options' => ['a' => 'Hydrogen', 'b' => 'Oxygen', 'c' => 'Helium', 'd' => 'Nitrogen'], 'correct' => 'c', 'explanation' => 'Helium is a noble gas.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'What is the most abundant element in the universe?', 'options' => ['a' => 'Oxygen', 'b' => 'Carbon', 'c' => 'Hydrogen', 'd' => 'Helium'], 'correct' => 'c', 'explanation' => 'Hydrogen is most abundant.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'The pH scale ranges from:', 'options' => ['a' => '0 to 10', 'b' => '0 to 14', 'c' => '1 to 15', 'd' => '1 to 10'], 'correct' => 'b', 'explanation' => 'pH scale is 0 to 14.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'Isotopes have the same number of:', 'options' => ['a' => 'Neutrons', 'b' => 'Protons', 'c' => 'Electrons and neutrons', 'd' => 'Mass number'], 'correct' => 'b', 'explanation' => 'Isotopes have same protons.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'Which gas is produced when metals react with acids?', 'options' => ['a' => 'Oxygen', 'b' => 'Carbon dioxide', 'c' => 'Hydrogen', 'd' => 'Nitrogen'], 'correct' => 'c', 'explanation' => 'Metals + acids produce hydrogen.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'The number of electrons in neutral atom equals:', 'options' => ['a' => 'Neutrons', 'b' => 'Protons', 'c' => 'Nucleons', 'd' => 'Isotopes'], 'correct' => 'b', 'explanation' => 'Electrons equal protons in neutral atom.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'What is the chemical formula for water?', 'options' => ['a' => 'H₂O', 'b' => 'HO₂', 'c' => 'H₃O', 'd' => 'HO'], 'correct' => 'a', 'explanation' => 'Water is H₂O.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'Which acid is found in vinegar?', 'options' => ['a' => 'Hydrochloric acid', 'b' => 'Sulfuric acid', 'c' => 'Acetic acid', 'd' => 'Nitric acid'], 'correct' => 'c', 'explanation' => 'Vinegar contains acetic acid.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Chemistry', 'question' => 'The chemical symbol for sodium is:', 'options' => ['a' => 'So', 'b' => 'Na', 'c' => 'S', 'd' => 'Sd'], 'correct' => 'b', 'explanation' => 'Sodium symbol is Na.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'What is the hardest natural substance?', 'options' => ['a' => 'Gold', 'b' => 'Iron', 'c' => 'Diamond', 'd' => 'Platinum'], 'correct' => 'c', 'explanation' => 'Diamond is hardest natural substance.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'Which gas is used in photosynthesis?', 'options' => ['a' => 'Oxygen', 'b' => 'Nitrogen', 'c' => 'Carbon dioxide', 'd' => 'Hydrogen'], 'correct' => 'c', 'explanation' => 'Plants use CO₂ in photosynthesis.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Chemistry', 'question' => 'The atomic mass of hydrogen is approximately:', 'options' => ['a' => '1', 'b' => '2', 'c' => '3', 'd' => '4'], 'correct' => 'a', 'explanation' => 'Hydrogen atomic mass is about 1.', 'difficulty' => 1, 'marks' => 1],

            // Biology Questions (20 questions)
            ['subject' => 'Biology', 'question' => 'What is the basic unit of life?', 'options' => ['a' => 'Tissue', 'b' => 'Organ', 'c' => 'Cell', 'd' => 'Organism'], 'correct' => 'c', 'explanation' => 'Cell is the basic unit of life.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Which organelle is the powerhouse of cell?', 'options' => ['a' => 'Nucleus', 'b' => 'Mitochondria', 'c' => 'Ribosome', 'd' => 'Golgi apparatus'], 'correct' => 'b', 'explanation' => 'Mitochondria is the powerhouse.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'DNA stands for:', 'options' => ['a' => 'Deoxyribonucleic acid', 'b' => 'Dinitrogen acid', 'c' => 'Deoxyribose acid', 'd' => 'Dinucleotide acid'], 'correct' => 'a', 'explanation' => 'DNA is deoxyribonucleic acid.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Plants make food through:', 'options' => ['a' => 'Respiration', 'b' => 'Photosynthesis', 'c' => 'Transpiration', 'd' => 'Digestion'], 'correct' => 'b', 'explanation' => 'Plants use photosynthesis.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Human heart has how many chambers?', 'options' => ['a' => '2', 'b' => '3', 'c' => '4', 'd' => '5'], 'correct' => 'c', 'explanation' => 'Human heart has 4 chambers.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Which blood type is universal donor?', 'options' => ['a' => 'A', 'b' => 'B', 'c' => 'AB', 'd' => 'O'], 'correct' => 'd', 'explanation' => 'Type O is universal donor.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'The largest organ in human body is:', 'options' => ['a' => 'Liver', 'b' => 'Brain', 'c' => 'Skin', 'd' => 'Lungs'], 'correct' => 'c', 'explanation' => 'Skin is the largest organ.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Normal human body temperature is:', 'options' => ['a' => '35°C', 'b' => '36°C', 'c' => '37°C', 'd' => '38°C'], 'correct' => 'c', 'explanation' => 'Normal temperature is 37°C.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Which vitamin is produced by sunlight?', 'options' => ['a' => 'Vitamin A', 'b' => 'Vitamin C', 'c' => 'Vitamin D', 'd' => 'Vitamin K'], 'correct' => 'c', 'explanation' => 'Sunlight helps produce Vitamin D.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'What is the function of ribosomes?', 'options' => ['a' => 'Energy production', 'b' => 'Protein synthesis', 'c' => 'DNA replication', 'd' => 'Waste removal'], 'correct' => 'b', 'explanation' => 'Ribosomes synthesize proteins.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'Which cells fight infections?', 'options' => ['a' => 'Red blood cells', 'b' => 'White blood cells', 'c' => 'Platelets', 'd' => 'Plasma cells'], 'correct' => 'b', 'explanation' => 'White blood cells fight infections.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Cell division producing gametes is:', 'options' => ['a' => 'Mitosis', 'b' => 'Meiosis', 'c' => 'Binary fission', 'd' => 'Budding'], 'correct' => 'b', 'explanation' => 'Meiosis produces gametes.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'Main function of kidneys is:', 'options' => ['a' => 'Digestion', 'b' => 'Circulation', 'c' => 'Filtration', 'd' => 'Respiration'], 'correct' => 'c', 'explanation' => 'Kidneys filter blood.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Which part controls balance?', 'options' => ['a' => 'Cerebrum', 'b' => 'Cerebellum', 'c' => 'Medulla', 'd' => 'Hypothalamus'], 'correct' => 'b', 'explanation' => 'Cerebellum controls balance.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'Who proposed evolution theory?', 'options' => ['a' => 'Mendel', 'b' => 'Darwin', 'c' => 'Watson', 'd' => 'Pasteur'], 'correct' => 'b', 'explanation' => 'Darwin proposed evolution.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'How many chromosomes in human cells?', 'options' => ['a' => '44', 'b' => '45', 'c' => '46', 'd' => '47'], 'correct' => 'c', 'explanation' => 'Humans have 46 chromosomes.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Biology', 'question' => 'What carries oxygen in blood?', 'options' => ['a' => 'Plasma', 'b' => 'Platelets', 'c' => 'Red blood cells', 'd' => 'White blood cells'], 'correct' => 'c', 'explanation' => 'Red blood cells carry oxygen.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'The study of heredity is called:', 'options' => ['a' => 'Ecology', 'b' => 'Genetics', 'c' => 'Anatomy', 'd' => 'Physiology'], 'correct' => 'b', 'explanation' => 'Genetics studies heredity.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'Which gas do plants release during photosynthesis?', 'options' => ['a' => 'Carbon dioxide', 'b' => 'Nitrogen', 'c' => 'Oxygen', 'd' => 'Hydrogen'], 'correct' => 'c', 'explanation' => 'Plants release oxygen.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Biology', 'question' => 'The smallest unit of genetic information is:', 'options' => ['a' => 'Chromosome', 'b' => 'Gene', 'c' => 'DNA', 'd' => 'Cell'], 'correct' => 'b', 'explanation' => 'Gene is smallest genetic unit.', 'difficulty' => 2, 'marks' => 2],

            // History Questions (20 questions)
            ['subject' => 'History', 'question' => 'World War II ended in which year?', 'options' => ['a' => '1944', 'b' => '1945', 'c' => '1946', 'd' => '1947'], 'correct' => 'b', 'explanation' => 'WWII ended in 1945.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'First US President was:', 'options' => ['a' => 'Jefferson', 'b' => 'Adams', 'c' => 'Washington', 'd' => 'Franklin'], 'correct' => 'c', 'explanation' => 'Washington was first president.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'French Revolution began in:', 'options' => ['a' => '1789', 'b' => '1790', 'c' => '1791', 'd' => '1792'], 'correct' => 'a', 'explanation' => 'French Revolution started 1789.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Julius Caesar ruled which empire?', 'options' => ['a' => 'Greek', 'b' => 'Roman', 'c' => 'Persian', 'd' => 'Egyptian'], 'correct' => 'b', 'explanation' => 'Caesar ruled Roman Empire.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'Berlin Wall fell in:', 'options' => ['a' => '1987', 'b' => '1988', 'c' => '1989', 'd' => '1990'], 'correct' => 'c', 'explanation' => 'Berlin Wall fell in 1989.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Renaissance began in which country?', 'options' => ['a' => 'France', 'b' => 'England', 'c' => 'Italy', 'd' => 'Germany'], 'correct' => 'c', 'explanation' => 'Renaissance started in Italy.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'American Civil War was between:', 'options' => ['a' => 'East and West', 'b' => 'North and South', 'c' => 'States and Federal', 'd' => 'Rich and Poor'], 'correct' => 'b', 'explanation' => 'Civil War: North vs South.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'Magna Carta was signed in:', 'options' => ['a' => '1215', 'b' => '1225', 'c' => '1235', 'd' => '1245'], 'correct' => 'a', 'explanation' => 'Magna Carta signed 1215.', 'difficulty' => 3, 'marks' => 3],
            ['subject' => 'History', 'question' => 'Who wrote Communist Manifesto?', 'options' => ['a' => 'Lenin', 'b' => 'Marx and Engels', 'c' => 'Stalin', 'd' => 'Trotsky'], 'correct' => 'b', 'explanation' => 'Marx and Engels wrote it.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Hanging Gardens were in:', 'options' => ['a' => 'Egypt', 'b' => 'Greece', 'c' => 'Babylon', 'd' => 'Rome'], 'correct' => 'c', 'explanation' => 'Hanging Gardens in Babylon.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'World War I started in:', 'options' => ['a' => '1912', 'b' => '1913', 'c' => '1914', 'd' => '1915'], 'correct' => 'c', 'explanation' => 'WWI started in 1914.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'Napoleon was defeated at:', 'options' => ['a' => 'Austerlitz', 'b' => 'Waterloo', 'c' => 'Leipzig', 'd' => 'Jena'], 'correct' => 'b', 'explanation' => 'Napoleon defeated at Waterloo.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Industrial Revolution started in:', 'options' => ['a' => 'France', 'b' => 'Germany', 'c' => 'Britain', 'd' => 'America'], 'correct' => 'c', 'explanation' => 'Industrial Revolution in Britain.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Pearl Harbor attack was in:', 'options' => ['a' => '1940', 'b' => '1941', 'c' => '1942', 'd' => '1943'], 'correct' => 'b', 'explanation' => 'Pearl Harbor attacked 1941.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Cold War was between:', 'options' => ['a' => 'USA and China', 'b' => 'USA and USSR', 'c' => 'Britain and France', 'd' => 'Germany and Italy'], 'correct' => 'b', 'explanation' => 'Cold War: USA vs USSR.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'Alexander the Great was from:', 'options' => ['a' => 'Rome', 'b' => 'Greece', 'c' => 'Macedonia', 'd' => 'Persia'], 'correct' => 'c', 'explanation' => 'Alexander from Macedonia.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Titanic sank in:', 'options' => ['a' => '1910', 'b' => '1911', 'c' => '1912', 'd' => '1913'], 'correct' => 'c', 'explanation' => 'Titanic sank in 1912.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'History', 'question' => 'Great Wall of China built to defend against:', 'options' => ['a' => 'Mongols', 'b' => 'Japanese', 'c' => 'Russians', 'd' => 'British'], 'correct' => 'a', 'explanation' => 'Built against Mongols.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Boston Tea Party happened in:', 'options' => ['a' => '1771', 'b' => '1772', 'c' => '1773', 'd' => '1774'], 'correct' => 'c', 'explanation' => 'Boston Tea Party in 1773.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'History', 'question' => 'Roman Empire fell in:', 'options' => ['a' => '476 AD', 'b' => '486 AD', 'c' => '496 AD', 'd' => '506 AD'], 'correct' => 'a', 'explanation' => 'Rome fell in 476 AD.', 'difficulty' => 3, 'marks' => 3],

            // Geography Questions (20 questions)
            ['subject' => 'Geography', 'question' => 'Largest continent by area is:', 'options' => ['a' => 'Africa', 'b' => 'Asia', 'c' => 'North America', 'd' => 'Europe'], 'correct' => 'b', 'explanation' => 'Asia is largest continent.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Longest river in the world is:', 'options' => ['a' => 'Amazon', 'b' => 'Nile', 'c' => 'Mississippi', 'd' => 'Yangtze'], 'correct' => 'b', 'explanation' => 'Nile is longest river.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Capital of Australia is:', 'options' => ['a' => 'Sydney', 'b' => 'Melbourne', 'c' => 'Canberra', 'd' => 'Perth'], 'correct' => 'c', 'explanation' => 'Canberra is capital of Australia.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Mount Everest is in:', 'options' => ['a' => 'Andes', 'b' => 'Rockies', 'c' => 'Himalayas', 'd' => 'Alps'], 'correct' => 'c', 'explanation' => 'Everest is in Himalayas.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Sahara Desert is in:', 'options' => ['a' => 'Asia', 'b' => 'Africa', 'c' => 'Australia', 'd' => 'South America'], 'correct' => 'b', 'explanation' => 'Sahara is in Africa.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Largest ocean is:', 'options' => ['a' => 'Atlantic', 'b' => 'Indian', 'c' => 'Pacific', 'd' => 'Arctic'], 'correct' => 'c', 'explanation' => 'Pacific is largest ocean.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Smallest country is:', 'options' => ['a' => 'Monaco', 'b' => 'Vatican City', 'c' => 'San Marino', 'd' => 'Liechtenstein'], 'correct' => 'b', 'explanation' => 'Vatican City is smallest.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Great Barrier Reef is near:', 'options' => ['a' => 'Brazil', 'b' => 'Australia', 'c' => 'Philippines', 'd' => 'Indonesia'], 'correct' => 'b', 'explanation' => 'Great Barrier Reef near Australia.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Equator passes through how many countries?', 'options' => ['a' => '11', 'b' => '12', 'c' => '13', 'd' => '14'], 'correct' => 'c', 'explanation' => 'Equator passes through 13 countries.', 'difficulty' => 3, 'marks' => 3],
            ['subject' => 'Geography', 'question' => 'Which country has most time zones?', 'options' => ['a' => 'Russia', 'b' => 'USA', 'c' => 'China', 'd' => 'France'], 'correct' => 'd', 'explanation' => 'France has most time zones.', 'difficulty' => 3, 'marks' => 3],
            ['subject' => 'Geography', 'question' => 'Dead Sea is between:', 'options' => ['a' => 'Israel and Jordan', 'b' => 'Egypt and Sudan', 'c' => 'Turkey and Greece', 'd' => 'Iran and Iraq'], 'correct' => 'a', 'explanation' => 'Dead Sea between Israel and Jordan.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Amazon rainforest is mainly in:', 'options' => ['a' => 'Colombia', 'b' => 'Brazil', 'c' => 'Peru', 'd' => 'Venezuela'], 'correct' => 'b', 'explanation' => 'Amazon mainly in Brazil.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Highest waterfall is:', 'options' => ['a' => 'Niagara Falls', 'b' => 'Victoria Falls', 'c' => 'Angel Falls', 'd' => 'Iguazu Falls'], 'correct' => 'c', 'explanation' => 'Angel Falls is highest.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Deepest ocean trench is:', 'options' => ['a' => 'Mariana Trench', 'b' => 'Puerto Rico Trench', 'c' => 'Java Trench', 'd' => 'Peru-Chile Trench'], 'correct' => 'a', 'explanation' => 'Mariana Trench is deepest.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Largest island is:', 'options' => ['a' => 'Madagascar', 'b' => 'Greenland', 'c' => 'New Guinea', 'd' => 'Borneo'], 'correct' => 'b', 'explanation' => 'Greenland is largest island.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Andes mountains are in:', 'options' => ['a' => 'North America', 'b' => 'Asia', 'c' => 'South America', 'd' => 'Africa'], 'correct' => 'c', 'explanation' => 'Andes are in South America.', 'difficulty' => 1, 'marks' => 1],
            ['subject' => 'Geography', 'question' => 'Largest lake is:', 'options' => ['a' => 'Superior', 'b' => 'Victoria', 'c' => 'Caspian Sea', 'd' => 'Baikal'], 'correct' => 'c', 'explanation' => 'Caspian Sea is largest lake.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Suez Canal connects:', 'options' => ['a' => 'Red Sea and Mediterranean', 'b' => 'Atlantic and Pacific', 'c' => 'Black Sea and Mediterranean', 'd' => 'Indian and Pacific'], 'correct' => 'a', 'explanation' => 'Suez connects Red Sea and Mediterranean.', 'difficulty' => 2, 'marks' => 2],
            ['subject' => 'Geography', 'question' => 'Driest desert is:', 'options' => ['a' => 'Sahara', 'b' => 'Gobi', 'c' => 'Atacama', 'd' => 'Kalahari'], 'correct' => 'c', 'explanation' => 'Atacama is driest desert.', 'difficulty' => 3, 'marks' => 3],
            ['subject' => 'Geography', 'question' => 'Ring of Fire is around:', 'options' => ['a' => 'Atlantic Ocean', 'b' => 'Pacific Ocean', 'c' => 'Indian Ocean', 'd' => 'Arctic Ocean'], 'correct' => 'b', 'explanation' => 'Ring of Fire around Pacific.', 'difficulty' => 2, 'marks' => 2]
        ];
    }
}