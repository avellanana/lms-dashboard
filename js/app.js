const courses = [
    {
        name: "Python",
        progress: 82,
        students: 120
    },
    {
        name: "Moodle",
        progress: 64,
        students: 95
    },
    {
        name: "Excel",
        progress: 91,
        students: 150
    },
    {
        name: "JavaScript",
        progress: 73,
        students: 110
    }
];

const totalCourses = document.getElementById("totalCourses");
const searchInput = document.getElementById("searchInput");
const progressInput = document.getElementById("progressInput");
const sortButton = document.getElementById("sortButton");

let searchText = "";
searchInput.addEventListener("input", function() {

    searchText = searchInput.value.toLowerCase();

    displayCourses(getFilteredCourses());
});

const courseList = document.getElementById("courseList");
const filterButton = document.getElementById("filterButton");
const resetButton = document.getElementById("resetButton");

let showingFiltered = false;

function updateSummary() {

    let studentCount = 0;
    let totalProgress = 0;

    courses.forEach(function(course) {
        studentCount = studentCount + course.students;
        totalProgress = totalProgress + course.progress;
    });

    const averageProgress = totalProgress / courses.length;

    totalStudents.textContent = studentCount;
    completionRate.textContent = Math.round(averageProgress) + "%";
    totalCourses.textContent = courses.length;
    
}

updateSummary();
displayCourses(courses);

function getCoursesAboveProgress(minProgress) {

    return courses.filter(function(course) {
        return course.progress >= minProgress;
    });
}

function getFilteredCourses() {

    let result = courses;

    if (searchText !== "") {
        result = result.filter(function(course) {
            return course.name.toLowerCase().includes(searchText);
        });
    }

    if (showingFiltered) {

    const minProgress = Number(progressInput.value);

    result = result.filter(function(course) {
        return course.progress >= minProgress;
    });
}

    return result;
}

let sortDescending = true;
sortButton.addEventListener("click", function() {

    const sortedCourses = [...getFilteredCourses()].sort(function(a, b) {

        if (sortDescending) {
            return b.progress - a.progress;
        } else {
            return a.progress - b.progress;
        }

    });

    displayCourses(sortedCourses);

    sortDescending = !sortDescending;

});

function displayCourses(courseArray) {

    courseList.innerHTML = "";

    if (courseArray.length === 0) {
    courseList.innerHTML = "<p>No se encontraron cursos.</p>";
    return;
}

    courseArray.forEach(function(course) {

        const courseElement = document.createElement("div");

        courseElement.classList.add("course");

        courseElement.innerHTML = `
            <div class="course-info">
                <span>${course.name}</span>
                <span>${course.students} estudiantes</span>
            </div>

            <div class="progress-bar">
                <div class="progress" style="width: ${course.progress}%"></div>
            </div>
        `;

        courseList.appendChild(courseElement);
    });
}

filterButton.addEventListener("click", function() {

    showingFiltered = true;

    displayCourses(getFilteredCourses());

});

resetButton.addEventListener("click", function() {

    searchInput.value = "";
    searchText = "";

    progressInput.value = 80;

    showingFiltered = false;

    displayCourses(courses);

});