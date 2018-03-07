<?php
	namespace App\Search\Operators;

	use App\Search\Exception\InvalidFieldValueException;
	use App\Search\OperatorInterface;
	use App\Search\SearchQuery;
	use Doctrine\ORM\Query\Expr\Composite;
	use Doctrine\ORM\Query\Expr\Orx;

	class OrOperator implements OperatorInterface {
		/**
		 * {@inheritdoc}
		 */
		public function process(SearchQuery $query, string $key, $argument, int &$paramIndex, Composite $node): void {
			if (!is_array($argument))
				throw new InvalidFieldValueException($key . '.$or', 'array');

			$orX = new Orx();

			foreach ($argument as $arg)
				$query->process($arg, $paramIndex, $orX);

			$node->add($orX);
		}
	}