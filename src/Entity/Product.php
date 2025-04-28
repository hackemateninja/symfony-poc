<?php
	
	namespace App\Entity;
	
	use App\Repository\ProductRepository;
	use Doctrine\DBAL\Types\Types;
	use Doctrine\ORM\Mapping as ORM;
	
	#[ORM\Entity(repositoryClass: ProductRepository::class)]
	#[ORM\HasLifecycleCallbacks]
	class Product
	{
		#[ORM\Id]
		#[ORM\GeneratedValue]
		#[ORM\Column]
		private ?int $id = null;
		
		#[ORM\Column(length: 255)]
		private ?string $name = null;
		
		#[ORM\Column(type: Types::TEXT, nullable: true)]
		private ?string $description = null;
		
		#[ORM\Column]
		private ?int $size = null;
		
		#[ORM\Column]
		private ?\DateTimeImmutable $createdAt = null;
		
		#[ORM\Column]
		private ?\DateTimeImmutable $updatedAt = null;
		
		
		public function getId(): ?int
		{
			return $this->id;
		}
		
		public function getName(): ?string
		{
			return $this->name;
		}
		
		public function setName(string $name): static
		{
			$this->name = $name;
			
			return $this;
		}
		
		public function getDescription(): ?string
		{
			return $this->description;
		}
		
		public function setDescription(?string $description): static
		{
			$this->description = $description;
			
			return $this;
		}
		
		public function getSize(): ?int
		{
			return $this->size;
		}
		
		public function setSize(int $size): static
		{
			$this->size = $size;
			
			return $this;
		}
		
		public function getCreatedAt(): ?\DateTimeImmutable
		{
			return $this->createdAt;
		}
		
		public function setCreatedAt(\DateTimeImmutable $createdAt): static
		{
			$this->createdAt = $createdAt;
			
			return $this;
		}
		
		public function getUpdatedAt(): ?\DateTimeImmutable
		{
			return $this->updatedAt;
		}
		
		public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
		{
			$this->updatedAt = $updatedAt;
			
			return $this;
		}
		
		#[ORM\PrePersist]
		public function setCreatedAtValue(): void
		{
			$now = new \DateTimeImmutable();
			
			if ($this->createdAt === null) {
				$this->createdAt = $now;
			}
			if ($this->updatedAt === null) {
				$this->updatedAt = $now;
			}
		}
		
		#[ORM\PreUpdate]
		public function setUpdatedAtValue(): void
		{
			$this->updatedAt = new \DateTimeImmutable();
		}
	}
