const courses = [
    {
        name: "Python",
        progress: 82
    },
    {
        name: "Moodle",
        progress: 64
    },
    {
        name: "Excel",
        progress: 91
    },
    {
        name: "JavaScript",
        progress: 73
    }
];

const courseList = document.getElementById("courseList");

courses.forEach(function(course) {

    const courseElement = document.createElement("div");

    courseElement.classList.add("course");

    courseElement.innerHTML = `
    <div class="course-info">
        <span>${course.name}</span>
        <span>${course.progress}%</span>
    </div>

    <div class="progress-bar">
        <div class="progress" style="width: ${course.progress}%"></div>
    </div>
`;

    courseList.appendChild(courseElement);
});

const filterButton = document.getElementById("filterButton");
const resetButton = document.getElementById("resetButton");

let showingFiltered = false;

function displayCourses(courseArray) {

    courseList.innerHTML = "";

    courseArray.forEach(function(course) {

        const courseElement = document.createElement("div");

        courseElement.classList.add("course");

        courseElement.innerHTML = `
            <div class="course-info">
                <span>${course.name}</span>
                <span>${course.progress}%</span>
            </div>

            <div class="progress-bar">
                <div class="progress" style="width: ${course.progress}%"></div>
            </div>
        `;

        courseList.appendChild(courseElement);
    });
}

filterButton.addEventListener("click", function() {

    if (showingFiltered === false) {

        const filteredCourses = courses.filter(function(course) {
            return course.progress >= 80;
        });

        displayCourses(filteredCourses);

        showingFiltered = true;

        filterButton.textContent = "Mostrar todos";

    } else {

        displayCourses(courses);

        showingFiltered = false;

        filterButton.textContent = "Mostrar cursos ≥ 80%";
    }

});

resetButton.addEventListener("click", function() {

    displayCourses(courses);

    showingFiltered = false;

    filterButton.textContent = "Mostrar cursos ≥ 80%";

});