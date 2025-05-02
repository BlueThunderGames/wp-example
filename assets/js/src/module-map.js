document.addEventListener('DOMContentLoaded', () => {
	const mapSections = document.querySelectorAll('.m-map');

	const scrollToOffset = (element, offset) => {
		const elementRect = element.getBoundingClientRect();
		const absoluteElementBottom = elementRect.bottom + window.scrollY;
		const offsetPosition = absoluteElementBottom - window.innerHeight + offset;

		window.scrollTo({
			top: offsetPosition,
			behavior: 'smooth'
		});
	};

	mapSections.forEach(mapSection => {

		const mapPersons = mapSection.querySelectorAll('.map-person');
		const mapImg = mapSection.querySelector('.m-map__img');
		const mapButtons = mapSection.querySelectorAll('.region-btn');
		const mapItems = mapImg.querySelectorAll('path, g, polygon');

		const stateToRegionMap = {};

		mapButtons.forEach(button => {
			const regionId = button.getAttribute('data-region');
			const statesData = button.getAttribute('data-states');
			const statesArray = statesData.split(';');

			statesArray.forEach(state => {
				stateToRegionMap[state] = regionId;
			});
		});

		const disableMap = () => {
			mapItems.forEach(region => {
				region.classList.remove('active');
				mapImg.classList.remove('active');
			});

			mapButtons.forEach(btn => btn.classList.remove('active-btn'));
			mapPersons.forEach(person => {
				person.classList.remove('active-person');
			});
		};

		const activateRegionById = regionId => {
			const button = mapSection.querySelector(`.region-btn[data-region="${regionId}"]`);

			if (button) {
				const statesData = button.getAttribute('data-states');
				const statesArray = statesData.split(';');
				const person = mapSection.querySelector(`[data-person-region="${regionId}"]`);

				disableMap();
				button.classList.add('active-btn');

				if (person) {
					person.classList.add('active-person');

					if (window.innerWidth < 768) {
						scrollToOffset(person, 70);
					}
				}

				statesArray.forEach(state => {
					if (state === 'all') {
						mapImg.classList.add('active');
					} else {
						const selectedRegion = mapImg.getElementById(state);
						if (selectedRegion) {
							if (selectedRegion.tagName.toLowerCase() === 'g') {
								selectedRegion.querySelectorAll('path').forEach(path => path.classList.add('active'));
							} else {
								selectedRegion.classList.add('active');
							}
						}
					}
				});
			}
		};

		mapButtons.forEach(button => {
			button.addEventListener('click', () => {
				const regionId = button.getAttribute('data-region');
				activateRegionById(regionId);
			});
		});

		mapItems.forEach(item => {
			item.addEventListener('click', () => {
				const stateId = item.id;
				const regionId = stateToRegionMap[stateId];

				if (regionId) {
					activateRegionById(regionId);
				}
			});
		});

		const checkUrlForRegion = () => {
			const hash = window.location.hash;

			if (hash && hash.includes('#map&')) {
				const regionId = hash.split('&')[1];
				if (regionId) {
					const button = mapSection.querySelector(`.region-btn[data-region="${regionId}"]`);
					if (button) {
						activateRegionById(regionId);
						mapSection.scrollIntoView({ behavior: 'smooth' });
						history.replaceState(null, null, window.location.pathname + window.location.search);
					}
				}
			}
		};

		checkUrlForRegion();
	})
});
