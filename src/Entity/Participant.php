<?php

namespace App\Entity;

use App\Component\Rating;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Kiczort\PolishValidatorBundle\Validator\Constraints as KiczortAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use function Symfony\Component\Translation\t;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Kindergarten::class, inversedBy="participants")
     */
    private $kindergarten;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $childFirstname;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthAt;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expireAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedAt;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodBreakfast;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodDinner;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodGrain;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodDiary;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodFruits;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodVegetables;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodMeat;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodFastfood;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodBuying;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodChewing;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodDrinking;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodEating;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodAllowing;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodTv;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodSupplements;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodFeeding;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodActivity;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodTvGames;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodDevelopment;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $foodWeight;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $nicotineEnvironment;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $nicotineHome;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $immuneCorrect;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $sleepProblems;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $sleepTired;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $sleepNapping;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $sleepAwakening;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $sleepDuration;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $sleepBreathe;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalUsing;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalInternet;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalGames;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalDisturb;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalRewarding;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalTime;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $digitalBored;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialIdeas;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialNew;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialEquals;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialExpress;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialCurious;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialNeeds;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialHelp;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialCreative;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialAgression;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialThrow;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialScream;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialAngry;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialResist;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialUnpatient;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $socialDischarge;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsEmbarrass;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsNewplace;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsNewperson;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsChanges;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsLost;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsNewguardian;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsNotself;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsKindergarten;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsCompletion;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsOnetoy;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsDin;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsPerseverance;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsTrying;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsDiscourage;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $emotionsFocus;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $weightBodymass;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $weightHeight;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $activityWeek;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $activity3days;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $activity10minutes;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $fitnessJump;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $fitnessAlternRun;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $fitnessStand;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $fitnessRun20;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $standRating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $alternRunRating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $jumpRating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $run20Rating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $weightBmi;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $weightBmiCentile;
	
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusFood;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusNicotine;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusImmune;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusSleep;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusDigital;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusAdaptation;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusExternal;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusNewness;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusFocus;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusWeight;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusActivity;
	
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $statusFitness;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $currentStep;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKindergarten(): ?Kindergarten
    {
        return $this->kindergarten;
    }

    public function setKindergarten(?Kindergarten $kindergarten): self
    {
        $this->kindergarten = $kindergarten;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getChildFirstname(): ?string
    {
        return $this->childFirstname;
    }

    public function setChildFirstname(?string $childFirstname): self
    {
        $this->childFirstname = $childFirstname;

        return $this;
    }

    public function getBirthAt(): ?\DateTimeInterface
    {
        return $this->birthAt;
    }

    public function setBirthAt(?\DateTimeInterface $birthAt): self
    {
        $this->birthAt = $birthAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(?\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getFoodBreakfast(): ?string
    {
        return $this->foodBreakfast;
    }

    public function setFoodBreakfast(?string $foodBreakfast): self
    {
        $this->foodBreakfast = $foodBreakfast;

        return $this;
    }

    public function getFoodDinner(): ?string
    {
        return $this->foodDinner;
    }

    public function setFoodDinner(?string $foodDinner): self
    {
        $this->foodDinner = $foodDinner;

        return $this;
    }

    public function getFoodGrain(): ?string
    {
        return $this->foodGrain;
    }

    public function setFoodGrain(?string $foodGrain): self
    {
        $this->foodGrain = $foodGrain;

        return $this;
    }

    public function getFoodDiary(): ?string
    {
        return $this->foodDiary;
    }

    public function setFoodDiary(?string $foodDiary): self
    {
        $this->foodDiary = $foodDiary;

        return $this;
    }

    public function getFoodFruits(): ?string
    {
        return $this->foodFruits;
    }

    public function setFoodFruits(?string $foodFruits): self
    {
        $this->foodFruits = $foodFruits;

        return $this;
    }

    public function getFoodVegetables(): ?string
    {
        return $this->foodVegetables;
    }

    public function setFoodVegetables(?string $foodVegetables): self
    {
        $this->foodVegetables = $foodVegetables;

        return $this;
    }

    public function getFoodMeat(): ?string
    {
        return $this->foodMeat;
    }

    public function setFoodMeat(?string $foodMeat): self
    {
        $this->foodMeat = $foodMeat;

        return $this;
    }

    public function getFoodFastfood(): ?string
    {
        return $this->foodFastfood;
    }

    public function setFoodFastfood(?string $foodFastfood): self
    {
        $this->foodFastfood = $foodFastfood;

        return $this;
    }

    public function getFoodBuying(): ?string
    {
        return $this->foodBuying;
    }

    public function setFoodBuying(?string $foodBuying): self
    {
        $this->foodBuying = $foodBuying;

        return $this;
    }

    public function getFoodChewing(): ?string
    {
        return $this->foodChewing;
    }

    public function setFoodChewing(?string $foodChewing): self
    {
        $this->foodChewing = $foodChewing;

        return $this;
    }

    public function getFoodDrinking(): ?string
    {
        return $this->foodDrinking;
    }

    public function setFoodDrinking(?string $foodDrinking): self
    {
        $this->foodDrinking = $foodDrinking;

        return $this;
    }

    public function getFoodEating(): ?string
    {
        return $this->foodEating;
    }

    public function setFoodEating(?string $foodEating): self
    {
        $this->foodEating = $foodEating;

        return $this;
    }

    public function getFoodAllowing(): ?string
    {
        return $this->foodAllowing;
    }

    public function setFoodAllowing(?string $foodAllowing): self
    {
        $this->foodAllowing = $foodAllowing;

        return $this;
    }

    public function getFoodTv(): ?string
    {
        return $this->foodTv;
    }

    public function setFoodTv(?string $foodTv): self
    {
        $this->foodTv = $foodTv;

        return $this;
    }

    public function getFoodSupplements(): ?string
    {
        return $this->foodSupplements;
    }

    public function setFoodSupplements(?string $foodSupplements): self
    {
        $this->foodSupplements = $foodSupplements;

        return $this;
    }

    public function getFoodFeeding(): ?string
    {
        return $this->foodFeeding;
    }

    public function setFoodFeeding(?string $foodFeeding): self
    {
        $this->foodFeeding = $foodFeeding;

        return $this;
    }

    public function getFoodActivity(): ?string
    {
        return $this->foodActivity;
    }

    public function setFoodActivity(?string $foodActivity): self
    {
        $this->foodActivity = $foodActivity;

        return $this;
    }

    public function getFoodTvGames(): ?string
    {
        return $this->foodTvGames;
    }

    public function setFoodTvGames(?string $foodTvGames): self
    {
        $this->foodTvGames = $foodTvGames;

        return $this;
    }

    public function getFoodDevelopment(): ?string
    {
        return $this->foodDevelopment;
    }

    public function setFoodDevelopment(?string $foodDevelopment): self
    {
        $this->foodDevelopment = $foodDevelopment;

        return $this;
    }

    public function getFoodWeight(): ?string
    {
        return $this->foodWeight;
    }

    public function setFoodWeight(?string $foodWeight): self
    {
        $this->foodWeight = $foodWeight;

        return $this;
    }

    public function getNicotineEnvironment(): ?string
    {
        return $this->nicotineEnvironment;
    }

    public function setNicotineEnvironment(?string $nicotineEnvironment): self
    {
        $this->nicotineEnvironment = $nicotineEnvironment;

        return $this;
    }

    public function getNicotineHome(): ?string
    {
        return $this->nicotineHome;
    }

    public function setNicotineHome(?string $nicotineHome): self
    {
        $this->nicotineHome = $nicotineHome;

        return $this;
    }

    public function getImmuneCorrect(): ?string
    {
        return $this->immuneCorrect;
    }

    public function setImmuneCorrect(?string $immuneCorrect): self
    {
        $this->immuneCorrect = $immuneCorrect;

        return $this;
    }

    public function getSleepProblems(): ?string
    {
        return $this->sleepProblems;
    }

    public function setSleepProblems(?string $sleepProblems): self
    {
        $this->sleepProblems = $sleepProblems;

        return $this;
    }

    public function getSleepTired(): ?string
    {
        return $this->sleepTired;
    }

    public function setSleepTired(?string $sleepTired): self
    {
        $this->sleepTired = $sleepTired;

        return $this;
    }

    public function getSleepNapping(): ?string
    {
        return $this->sleepNapping;
    }

    public function setSleepNapping(?string $sleepNapping): self
    {
        $this->sleepNapping = $sleepNapping;

        return $this;
    }

    public function getSleepAwakening(): ?string
    {
        return $this->sleepAwakening;
    }

    public function setSleepAwakening(?string $sleepAwakening): self
    {
        $this->sleepAwakening = $sleepAwakening;

        return $this;
    }

    public function getSleepDuration(): ?string
    {
        return $this->sleepDuration;
    }

    public function setSleepDuration(?string $sleepDuration): self
    {
        $this->sleepDuration = $sleepDuration;

        return $this;
    }

    public function getSleepBreathe(): ?string
    {
        return $this->sleepBreathe;
    }

    public function setSleepBreathe(?string $sleepBreathe): self
    {
        $this->sleepBreathe = $sleepBreathe;

        return $this;
    }

    public function getDigitalUsing(): ?string
    {
        return $this->digitalUsing;
    }

    public function setDigitalUsing(?string $digitalUsing): self
    {
        $this->digitalUsing = $digitalUsing;

        return $this;
    }

    public function getDigitalInternet(): ?string
    {
        return $this->digitalInternet;
    }

    public function setDigitalInternet(?string $digitalInternet): self
    {
        $this->digitalInternet = $digitalInternet;

        return $this;
    }

    public function getDigitalGames(): ?string
    {
        return $this->digitalGames;
    }

    public function setDigitalGames(?string $digitalGames): self
    {
        $this->digitalGames = $digitalGames;

        return $this;
    }

    public function getDigitalDisturb(): ?string
    {
        return $this->digitalDisturb;
    }

    public function setDigitalDisturb(?string $digitalDisturb): self
    {
        $this->digitalDisturb = $digitalDisturb;

        return $this;
    }

    public function getDigitalRewarding(): ?string
    {
        return $this->digitalRewarding;
    }

    public function setDigitalRewarding(?string $digitalRewarding): self
    {
        $this->digitalRewarding = $digitalRewarding;

        return $this;
    }

    public function getDigitalTime(): ?string
    {
        return $this->digitalTime;
    }

    public function setDigitalTime(?string $digitalTime): self
    {
        $this->digitalTime = $digitalTime;

        return $this;
    }

    public function getDigitalBored(): ?string
    {
        return $this->digitalBored;
    }

    public function setDigitalBored(?string $digitalBored): self
    {
        $this->digitalBored = $digitalBored;

        return $this;
    }

    public function getSocialIdeas(): ?string
    {
        return $this->socialIdeas;
    }

    public function setSocialIdeas(?string $socialIdeas): self
    {
        $this->socialIdeas = $socialIdeas;

        return $this;
    }

    public function getSocialNew(): ?string
    {
        return $this->socialNew;
    }

    public function setSocialNew(?string $socialNew): self
    {
        $this->socialNew = $socialNew;

        return $this;
    }

    public function getSocialEquals(): ?string
    {
        return $this->socialEquals;
    }

    public function setSocialEquals(?string $socialEquals): self
    {
        $this->socialEquals = $socialEquals;

        return $this;
    }

    public function getSocialExpress(): ?string
    {
        return $this->socialExpress;
    }

    public function setSocialExpress(?string $socialExpress): self
    {
        $this->socialExpress = $socialExpress;

        return $this;
    }

    public function getSocialCurious(): ?string
    {
        return $this->socialCurious;
    }

    public function setSocialCurious(?string $socialCurious): self
    {
        $this->socialCurious = $socialCurious;

        return $this;
    }

    public function getSocialNeeds(): ?string
    {
        return $this->socialNeeds;
    }

    public function setSocialNeeds(?string $socialNeeds): self
    {
        $this->socialNeeds = $socialNeeds;

        return $this;
    }

    public function getSocialHelp(): ?string
    {
        return $this->socialHelp;
    }

    public function setSocialHelp(?string $socialHelp): self
    {
        $this->socialHelp = $socialHelp;

        return $this;
    }

    public function getSocialCreative(): ?string
    {
        return $this->socialCreative;
    }

    public function setSocialCreative(?string $socialCreative): self
    {
        $this->socialCreative = $socialCreative;

        return $this;
    }

    public function getSocialAgression(): ?string
    {
        return $this->socialAgression;
    }

    public function setSocialAgression(?string $socialAgression): self
    {
        $this->socialAgression = $socialAgression;

        return $this;
    }

    public function getSocialThrow(): ?string
    {
        return $this->socialThrow;
    }

    public function setSocialThrow(?string $socialThrow): self
    {
        $this->socialThrow = $socialThrow;

        return $this;
    }

    public function getSocialScream(): ?string
    {
        return $this->socialScream;
    }

    public function setSocialScream(?string $socialScream): self
    {
        $this->socialScream = $socialScream;

        return $this;
    }

    public function getSocialAngry(): ?string
    {
        return $this->socialAngry;
    }

    public function setSocialAngry(?string $socialAngry): self
    {
        $this->socialAngry = $socialAngry;

        return $this;
    }

    public function getSocialResist(): ?string
    {
        return $this->socialResist;
    }

    public function setSocialResist(?string $socialResist): self
    {
        $this->socialResist = $socialResist;

        return $this;
    }

    public function getSocialUnpatient(): ?string
    {
        return $this->socialUnpatient;
    }

    public function setSocialUnpatient(?string $socialUnpatient): self
    {
        $this->socialUnpatient = $socialUnpatient;

        return $this;
    }

    public function getSocialDischarge(): ?string
    {
        return $this->socialDischarge;
    }

    public function setSocialDischarge(?string $socialDischarge): self
    {
        $this->socialDischarge = $socialDischarge;

        return $this;
    }

    public function getEmotionsEmbarrass(): ?string
    {
        return $this->emotionsEmbarrass;
    }

    public function setEmotionsEmbarrass(?string $emotionsEmbarrass): self
    {
        $this->emotionsEmbarrass = $emotionsEmbarrass;

        return $this;
    }

    public function getEmotionsNewplace(): ?string
    {
        return $this->emotionsNewplace;
    }

    public function setEmotionsNewplace(?string $emotionsNewplace): self
    {
        $this->emotionsNewplace = $emotionsNewplace;

        return $this;
    }

    public function getEmotionsNewperson(): ?string
    {
        return $this->emotionsNewperson;
    }

    public function setEmotionsNewperson(?string $emotionsNewperson): self
    {
        $this->emotionsNewperson = $emotionsNewperson;

        return $this;
    }

    public function getEmotionsChanges(): ?string
    {
        return $this->emotionsChanges;
    }

    public function setEmotionsChanges(?string $emotionsChanges): self
    {
        $this->emotionsChanges = $emotionsChanges;

        return $this;
    }

    public function getEmotionsLost(): ?string
    {
        return $this->emotionsLost;
    }

    public function setEmotionsLost(?string $emotionsLost): self
    {
        $this->emotionsLost = $emotionsLost;

        return $this;
    }

    public function getEmotionsNewguardian(): ?string
    {
        return $this->emotionsNewguardian;
    }

    public function setEmotionsNewguardian(?string $emotionsNewguardian): self
    {
        $this->emotionsNewguardian = $emotionsNewguardian;

        return $this;
    }

    public function getEmotionsNotself(): ?string
    {
        return $this->emotionsNotself;
    }

    public function setEmotionsNotself(?string $emotionsNotself): self
    {
        $this->emotionsNotself = $emotionsNotself;

        return $this;
    }

    public function getEmotionsKindergarten(): ?string
    {
        return $this->emotionsKindergarten;
    }

    public function setEmotionsKindergarten(?string $emotionsKindergarten): self
    {
        $this->emotionsKindergarten = $emotionsKindergarten;

        return $this;
    }

    public function getEmotionsCompletion(): ?string
    {
        return $this->emotionsCompletion;
    }

    public function setEmotionsCompletion(?string $emotionsCompletion): self
    {
        $this->emotionsCompletion = $emotionsCompletion;

        return $this;
    }

    public function getEmotionsOnetoy(): ?string
    {
        return $this->emotionsOnetoy;
    }

    public function setEmotionsOnetoy(?string $emotionsOnetoy): self
    {
        $this->emotionsOnetoy = $emotionsOnetoy;

        return $this;
    }

    public function getEmotionsDin(): ?string
    {
        return $this->emotionsDin;
    }

    public function setEmotionsDin(?string $emotionsDin): self
    {
        $this->emotionsDin = $emotionsDin;

        return $this;
    }

    public function getEmotionsPerseverance(): ?string
    {
        return $this->emotionsPerseverance;
    }

    public function setEmotionsPerseverance(?string $emotionsPerseverance): self
    {
        $this->emotionsPerseverance = $emotionsPerseverance;

        return $this;
    }

    public function getEmotionsTrying(): ?string
    {
        return $this->emotionsTrying;
    }

    public function setEmotionsTrying(?string $emotionsTrying): self
    {
        $this->emotionsTrying = $emotionsTrying;

        return $this;
    }

    public function getEmotionsDiscourage(): ?string
    {
        return $this->emotionsDiscourage;
    }

    public function setEmotionsDiscourage(?string $emotionsDiscourage): self
    {
        $this->emotionsDiscourage = $emotionsDiscourage;

        return $this;
    }

    public function getEmotionsFocus(): ?string
    {
        return $this->emotionsFocus;
    }

    public function setEmotionsFocus(?string $emotionsFocus): self
    {
        $this->emotionsFocus = $emotionsFocus;

        return $this;
    }

    public function getWeightBodymass(): ?string
    {
        return $this->weightBodymass;
    }

    public function setWeightBodymass(?string $weightBodymass): self
    {
        $this->weightBodymass = $weightBodymass;

        return $this;
    }

    public function getWeightHeight(): ?string
    {
        return $this->weightHeight;
    }

    public function setWeightHeight(?string $weightHeight): self
    {
        $this->weightHeight = $weightHeight;

        return $this;
    }

    public function getActivityWeek(): ?string
    {
        return $this->activityWeek;
    }

    public function setActivityWeek(?string $activityWeek): self
    {
        $this->activityWeek = $activityWeek;

        return $this;
    }

    public function getActivity3days(): ?string
    {
        return $this->activity3days;
    }

    public function setActivity3days(?string $activity3days): self
    {
        $this->activity3days = $activity3days;

        return $this;
    }

    public function getActivity10minutes(): ?string
    {
        return $this->activity10minutes;
    }

    public function setActivity10minutes(?string $activity10minutes): self
    {
        $this->activity10minutes = $activity10minutes;

        return $this;
    }

    public function getFitnessJump(): ?string
    {
        return $this->fitnessJump;
    }

    public function setFitnessJump(?string $fitnessJump): self
    {
        $this->fitnessJump = $fitnessJump;

        return $this;
    }

    public function getFitnessAlternRun(): ?string
    {
        return $this->fitnessAlternRun;
    }

    public function setFitnessAlternRun(?string $fitnessAlternRun): self
    {
        $this->fitnessAlternRun = $fitnessAlternRun;

        return $this;
    }

    public function getFitnessStand(): ?string
    {
        return $this->fitnessStand;
    }

    public function setFitnessStand(?string $fitnessStand): self
    {
        $this->fitnessStand = $fitnessStand;

        return $this;
    }

    public function getFitnessRun20(): ?string
    {
        return $this->fitnessRun20;
    }

    public function setFitnessRun20(?string $fitnessRun20): self
    {
        $this->fitnessRun20 = $fitnessRun20;

        return $this;
    }

    public function getStandRating(): ?string
    {
        return $this->standRating;
    }

    public function setStandRating(?string $standRating): self
    {
        $this->standRating = $standRating;

        return $this;
    }

    public function getAlternRunRating(): ?string
    {
        return $this->alternRunRating;
    }

    public function setAlternRunRating(?string $alternRunRating): self
    {
        $this->alternRunRating = $alternRunRating;

        return $this;
    }

    public function getJumpRating(): ?string
    {
        return $this->jumpRating;
    }

    public function setJumpRating(?string $jumpRating): self
    {
        $this->jumpRating = $jumpRating;

        return $this;
    }

    public function getRun20Rating(): ?string
    {
        return $this->run20Rating;
    }

    public function setRun20Rating(?string $run20Rating): self
    {
        $this->run20Rating = $run20Rating;

        return $this;
    }

    public function getCurrentStep(): ?string
    {
        return $this->currentStep;
    }

    public function setCurrentStep(?string $currentStep): self
    {
        $this->currentStep = $currentStep;

        return $this;
    }

    public function getWeightBmi(): ?string
    {
        return $this->weightBmi;
    }

    public function setWeightBmi(?string $weightBmi): self
    {
        $this->weightBmi = $weightBmi;

        return $this;
    }

    public function getWeightBmiCentile(): ?string
    {
        return $this->weightBmiCentile;
    }

    public function setWeightBmiCentile(?string $weightBmiCentile): self
    {
        $this->weightBmiCentile = $weightBmiCentile;

        return $this;
    }

    /**
     * @return float
     */
    public function getCurrentAge()
    {
        $today = new \DateTime();

        //Data urodzenia
        $bd = (int)$this->birthAt->format('d');
        $bm = (int)$this->birthAt->format('m');
        $by = (int)$this->birthAt->format('Y');

        //Data badania
        $md = (int)$today->format('d');
        $mm = (int)$today->format('m');
        $my = (int)$today->format('Y');

        //Obliczony wiek
        if ($mm < $bm) {
            $my = $my - 1;
            $mm = $mm + 12;
        }

        $age = (($md - $bd) + ($mm - $bm) * 30.5 + ($my - $by) * 30.5 * 12) / 365.25;

        return round($age, 2);
    }

    /**
     * @return int
     */
    public function getStatusFood():int
    {
        $points = 0;
        $status = 0;

        if ($this->getFoodBreakfast() < 3) $points++;
        if ($this->getFoodDinner() > 3) $points++;
        if ($this->getFoodGrain() == 2) $points++;
        if ($this->getFoodDiary() < 3) $points++;
        if ($this->getFoodFruits() > 2 && $this->getFoodFruits() < 5) $points++;
        if ($this->getFoodVegetables() == 1) $points++;
        if ($this->getFoodMeat() == 1) $points++;
        if ($this->getFoodFastfood() == 5) $points++;
        if ($this->getFoodBuying() > 2) $points++;
        if ($this->getFoodChewing() > 2) $points++;
        if ($this->getFoodDrinking() > 2) $points++;
        if ($this->getFoodEating() == 4) $points++;
        if ($this->getFoodAllowing() < 3) $points++;
        if ($this->getFoodTv() > 3) $points++;
        if ($this->getFoodSupplements() > 3) $points++;

        switch (true) {
            case ($points >= 13): $status = 1; break;
            case ($points >= 8): $status = 2; break;
            default: $status = 3; break;
        }

        return $status;
    }
	
    public function setStatusFood(?string $statusFood): self
    {
        $this->statusFood = $statusFood;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusNicotine():int
    {
        $status = 0;

        if ($this->getNicotineEnvironment() == 1 && $this->getNicotineHome() == 1) $status = 1;
        else $status = 2;

        return $status;
    }
	
    public function setStatusNicotine(?string $statusNicotine): self
    {
        $this->statusNicotine = $statusNicotine;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusImmune():int
    {
        $status = 0;

        if ($this->getImmuneCorrect() == 2) $status = 1;
        else $status = 2;

        return $status;
    }
	
    public function setStatusImmune(?string $statusImmune): self
    {
        $this->statusImmune = $statusImmune;

        return $this;
    }

    public function getStatusSleep():int
    {

        $points = 0;
        $status = 0;
        $age = $this->getCurrentAge();

        if ($this->getSleepProblems() == 1) $points++;
        if ($this->getSleepTired() == 1) $points++;
        if ($this->getSleepAwakening() == 1) $points++;
        if ($this->getSleepDuration() == 2) $points++;
        if ($this->getSleepBreathe() == 1) $points++;
        if ($age < 6.0 && $this->getSleepNapping() == 2) $points++;
        elseif ($age >= 6.0 && $this->getSleepNapping() == 1) $points++;

        switch (true) {
            case ($points == 6): $status = 1; break;
            case ($points == 5): $status = 2; break;
            default: $status = 3; break;
        }

        return $status;
    }
	
    public function setStatusSleep(?string $statusSleep): self
    {
        $this->statusSleep = $statusSleep;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusDigital():int
    {
        $var1 = 0;
        $var2 = 0;
        $status = 0;

        if ($this->getDigitalUsing() == 1) $var1++;
        elseif ($this->getDigitalUsing() == 2) $var2++;
        if ($this->getDigitalInternet() == 1) $var1++;
        elseif ($this->getDigitalInternet() == 2) $var2++;
        if ($this->getDigitalGames() == 1) $var1++;
        elseif ($this->getDigitalGames() == 2) $var2++;
        if ($this->getDigitalDisturb() == 1) $var1++;
        elseif ($this->getDigitalDisturb() == 2) $var2++;
        if ($this->getDigitalRewarding() == 1) $var1++;
        elseif ($this->getDigitalRewarding() == 2) $var2++;
        if ($this->getDigitalTime() == 1) $var1++;
        elseif ($this->getDigitalTime() == 2) $var2++;
        if ($this->getDigitalBored() == 1) $var1++;
        elseif ($this->getDigitalBored() == 2) $var2++;

        switch (true) {
            case ($var1 > 1): $status = 3; break;
            case ($var2 > 0 || $var1 > 0): $status = 2; break;
            default: $status = 1; break;
        }

        return $status;
    }
	
    public function setStatusDigital(?string $statusDigital): self
    {
        $this->statusDigital = $statusDigital;

        return $this;
    }

    public function getStatusAdaptation():int
    {
        $dataset = array();
        $a = 0;
        $status = 0;
        $points = ($this->getSocialIdeas()
            + $this->getSocialNew()
            + $this->getSocialEquals()
            + $this->getSocialExpress()
            + $this->getSocialCurious()
            + $this->getSocialNeeds()
            + $this->getSocialHelp()
            + $this->getSocialCreative() );

        $age = $this->getCurrentAge();
        $gender = $this->getGender();

        switch (true) {
            case ($age < 3.01): $a = 0; break;
            case ($age < 3.51): $a = 1; break;
            case ($age < 4.01): $a = 2; break;
            case ($age < 4.51): $a = 3; break;
            case ($age < 5.01): $a = 4; break;
            default: $a = 5; break;
        }

        if ($gender == 'M') {
            $dataset = array(
                array(22,26,32),
                array(22,26,32),
                array(22,26,32),
                array(23,27,32),
                array(22,26,32),
                array(22,26,32),
            );
        }
        elseif ($gender == 'F') {
            $dataset = array(
                array(23,27,32),
                array(22,26,32),
                array(23,27,32),
                array(22,26,32),
                array(23,27,32),
                array(23,27,32)
            );
        }

        for ($i=0; $i<3; $i++) {

            if ($points <= $dataset[$a][$i]) {
                $status = (3 - $i);
                break;
            }
        }

        return $status;
    }
	
    public function setStatusAdaptation(?string $statusAdaptation): self
    {
        $this->statusAdaptation = $statusAdaptation;

        return $this;
    }

    public function getStatusExternal():int
    {
        $age = $this->getCurrentAge();
        $gender = $this->getGender();

        $dataset = [];
        $a = 0;
        $status = 0;
        $points = ($this->getSocialAgression()
            + $this->getSocialThrow()
            + $this->getSocialScream()
            + $this->getSocialAngry()
            + $this->getSocialResist()
            + $this->getSocialUnpatient()
            + $this->getSocialDischarge());

        switch (true) {
            case ($age < 3.01):
                $a = 0;
                break;
            case ($age < 3.51):
                $a = 1;
                break;
            case ($age < 4.01):
                $a = 2;
                break;
            case ($age < 4.51):
                $a = 3;
                break;
            case ($age < 5.01):
                $a = 4;
                break;
            default:
                $a = 5;
                break;
        }

        if ($gender == 'M') {
            $dataset = array(
                array(14, 18, 28),
                array(14, 18, 28),
                array(14, 18, 28),
                array(13, 17, 28),
                array(13, 17, 28),
                array(12, 16, 28)
            );
        } elseif ($gender == 'F') {
            $dataset = array(
                array(12, 16, 28),
                array(13, 17, 28),
                array(13, 17, 28),
                array(12, 16, 28),
                array(11, 15, 28),
                array(12, 16, 28)
            );
        }

        for ($i = 0; $i < 3; $i++) {

            if ($points <= $dataset[$a][$i]) {
                $status = ($i + 1);
                break;
            }
        }

        return $status;
    }
	
    public function setStatusExternal(?string $statusExternal): self
    {
        $this->statusExternal = $statusExternal;

        return $this;
    }

    public function getStatusNewness():int
    {
        $age = $this->getCurrentAge();
        $gender = $this->getGender();

        $status = 0;
        $points = ( $this->getEmotionsEmbarrass()
            + $this->getEmotionsNewplace()
            + $this->getEmotionsNewperson()
            + $this->getEmotionsChanges()
            + $this->getEmotionsLost()
            + $this->getEmotionsNewguardian()
            + $this->getEmotionsNotself()
            + $this->getEmotionsKindergarten() );

        if ($gender == 'M' && $age > 4.58) {
            switch (true) {
                case ($points <= 11): $status = 3; break;
                case ($points <= 13): $status = 2; break;
                default: $status = 1; break;
            }
        } else {
            switch (true) {
                case ($points <= 10): $status = 3; break;
                case ($points <= 12): $status = 2; break;
                default: $status = 1; break;
            }
        }

	    return $status;
    }

    public function setStatusNewness(?string $statusNewness): self
    {
        $this->statusNewness = $statusNewness;

        return $this;
    }

    public function getStatusFocus():int
    {
        $status = 0;
        $points = ( $this->getEmotionsCompletion()
            + $this->getEmotionsOnetoy()
            + $this->getEmotionsDin()
            + $this->getEmotionsPerseverance()
            + $this->getEmotionsTrying()
            + $this->getEmotionsDiscourage()
            + $this->getEmotionsFocus() );

        switch (true) {
            case ($points <= 9): $status = 3; break;
            case ($points <= 11): $status = 2; break;
            default: $status = 1; break;
        }

        return $status;
    }
	
    public function setStatusFocus(?string $statusFocus): self
    {
        $this->statusFocus = $statusFocus;

        return $this;
    }
	
    public function getStatusWeight():int
    {
	//$weight_BMI_centile = $this->getWeightBmiCentile();
	$age = $this->getCurrentAge();
	$gender = $this->getGender();
	$bmi = $this->getWeightBodymass() / pow(($this->getWeightHeight()/100),2);

        /*
	switch (true) {
            case ($weight_BMI_centile < 10):
                $status = 3;
                break;
            case ($weight_BMI_centile > 85):
                $status = 2;
                break;
            default:
                $status = 1;
                break;
        }
	*/
		
		
	$dataset = [];
        $a = 0;
        $status = 6;
	
	switch (true) {
            	case ($age <= 2.2): $a = 0; break;
            	case ($age <= 2.7): $a = 1; break;
            	case ($age <= 3.2): $a = 2; break;
            	case ($age <= 3.7): $a = 3; break;
            	case ($age <= 4.2): $a = 4; break;
		case ($age <= 4.7): $a = 5; break;
		case ($age <= 5.2): $a = 6; break;
		case ($age <= 5.7): $a = 7; break;
		case ($age <= 6.2): $a = 8; break;
		case ($age <= 6.7): $a = 9; break;
            	default: $a = 10; break;
        }
		
	if ($gender == 'M') {
            $dataset = array(
                array(13.37, 14.12, 15.14, 18.41, 20.90),
		array(13.22, 13.94, 14.92, 18.13, 19.80),
		array(13.09, 13.79, 14.74, 17.89, 19.57),
		array(12.97, 13.64, 14.57, 17.69, 19.39),
		array(12.86, 13.52, 14.43, 17.55, 19.29),
		array(12.76, 13.41, 14.31, 17.47, 19.26),
		array(12.66, 13.31, 14.21, 17.42, 19.30),
		array(12.58, 13.22, 14.13, 17.45, 19.47),
		array(12.50, 13.15, 14.07, 17.55, 19.78),
		array(12.45, 13.10, 14.04, 17.71, 20.23),
		array(12.42, 13.08, 14.04, 17.92, 20.63)
            );
        } elseif ($gender == 'F') {
            $dataset = array(
                array(13.24, 13.90, 14.83, 18.02, 19.81),
		array(13.10, 13.74, 14.63, 17.76, 19.55),
		array(12.98, 13.60, 14.47, 17.56, 19.36),
		array(12.86, 13.47, 14.32, 17.40, 19.23),
		array(12.73, 13.34, 14.19, 17.28, 19.15),
		array(12.61, 13.21, 14.06, 17.19, 19.12),
		array(12.50, 13.09, 13.94, 17.15, 19.17),
		array(12.40, 12.99, 13.86, 17.20, 19.34),
		array(12.32, 12.93, 13.82, 17.34, 19.65),
		array(12.28, 12.90, 13.82, 17.53, 20.08),
		array(12.26, 12.91, 13.86, 17.75, 20.51)
            );
        }
		
	for ($i = 0; $i < 5; $i++) {
            if ($bmi < $dataset[$a][$i]) {
                $status = ($i + 1);
                break;
            }
        }

        return $status;
    }
	
    public function setStatusWeight(?string $statusWeight): self
    {
        $this->statusWeight = $statusWeight;

        return $this;
    }
	
    public function getStatusActivity():int
    {
        $status = 2;
        if ($this->getActivityWeek() == 2 && $this->getActivity3days() == 2 && $this->getActivity10minutes() == 2) {
            $status = 1;
        }
        return $status;
    }
	
    public function setStatusActivity(?string $statusActivity): self
    {
        $this->statusActivity = $statusActivity;

        return $this;
    }

    public function getStatusFitness():int
    {
        $rating = new Rating();

        $fitness_stand_rating = 0;
        $fitness_altern_run_rating = 0;
        $fitness_jump_rating = 0;
        $fitness_run20_rating = 0;

        if ($this->getFitnessStand()) {
            $fitness_stand_rating = $rating->get_fitness_stand_rating($this->getCurrentAge(), $this->getGender(), $this->getFitnessStand());
        }

        if ($this->getFitnessAlternRun()) {
            $fitness_altern_run_rating  = $rating->get_fitness_altern_run_rating($this->getCurrentAge(), $this->getGender(), $this->getFitnessAlternRun());
        }

        if ($this->getFitnessJump()) {
            $fitness_jump_rating = $rating->get_fitness_jump_rating($this->getCurrentAge(), $this->getGender(), $this->getFitnessJump());
        }

        if ($this->getFitnessRun20()) {
            $fitness_run20_rating = $rating->get_fitness_run20_rating($this->getCurrentAge(), $this->getGender(), $this->getFitnessRun20());
        }

        $status = 2;

        if ($fitness_jump_rating > 2 && $fitness_altern_run_rating > 2 && $fitness_stand_rating > 2 && $fitness_run20_rating > 2) {
            $status = 1;
        }
        elseif ($fitness_jump_rating <= 2 && $fitness_altern_run_rating <= 2 && $fitness_stand_rating <= 2 && $fitness_run20_rating <= 2) {
            $status = 3;
        }

        return $status;
    }
	
    public function setStatusFitness(?string $statusFitness): self
    {
        $this->statusFitness = $statusFitness;

        return $this;
    }
}
