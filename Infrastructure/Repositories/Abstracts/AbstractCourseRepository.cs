using System.Net;
using System.Text.Json;
using System.Text.Json.Serialization;
using LMSService.Domain.DTOs.Course;
using LMSService.Domain.Entities.Concretes;
using LMSService.Infrastructure.Connectors.Interfaces;
using LMSService.Infrastructure.Repositories.Interfaces;

namespace LMSService.Infrastructure.Connectors.Abstracts
{
    public abstract class AbstractCourseRepository(
        ILMSConnector lmsConnector
    ) : ICourseRepository
    {
        protected readonly ILMSConnector _lmsConnector = lmsConnector;

        public async Task<Course?> Create(CreateCourseDTO entity)
        {
            if (entity is null)
            {
                throw new ArgumentNullException(nameof(entity));
            }

            var course = new CourseWrapper(){
                Course = entity
            };

            var request = JsonSerializer.Serialize(entity);
            Console.WriteLine(request);

            var response = await _lmsConnector.PostAsync("v1/accounts/1/courses", request);
            
            if (response.StatusCode == HttpStatusCode.OK)
            {
                var content = await response.Content.ReadAsStringAsync();
                var newCourse = JsonSerializer.Deserialize<Course>(content);
                return newCourse;
            }
            return null;
        }

        public Task<Course?> Delete(int id)
        {
            throw new NotImplementedException();
        }

        public async Task<IEnumerable<Course>> GetAll(int pageNumber, int pageSize)
        {
            if (pageNumber < 1)
            {
                throw new ArgumentOutOfRangeException(nameof(pageNumber), "Page number must be greater than or equal to 1.");
            }
            if (pageSize < 1)
            {
                throw new ArgumentOutOfRangeException(nameof(pageSize), "Page size must be greater than or equal to 1.");
            }

            var response = await _lmsConnector.GetAsync("v1/courses");
            if (response is null)
            {
                throw new ArgumentException("Course empty");
            }
            var content = await response.Content.ReadAsStringAsync();
            var courses = JsonSerializer.Deserialize<IEnumerable<Course>>(content);
            if (courses is null)
            {
                throw new ArgumentException("Courses empty");
            }

            var skip = (pageNumber - 1) * pageSize;
            var take = pageSize;

            var courseList = courses.Skip(skip).Take(take);

            return courseList;
        }

        public async Task<IEnumerable<Course>> GetUserCoursesById(int userId, int pageNumber, int pageSize)
        {
            if (pageNumber < 1)
            {
                throw new ArgumentOutOfRangeException(nameof(pageNumber), "Page number must be greater than or equal to 1.");
            }
            if (pageSize < 1)
            {
                throw new ArgumentOutOfRangeException(nameof(pageNumber), "Page number must be greater than or equal to 1.");
            }
            if (userId < 1)
            {
                throw new ArgumentOutOfRangeException(nameof(userId), "User id must be greater than or equal to 1.");
            }

            var response = await _lmsConnector.GetAsync($"v1/users/{userId}/courses");
            if (response is null)
            {
                throw new ArgumentException("Course empty");
            }
            var content = await response.Content.ReadAsStringAsync();
            var courses = JsonSerializer.Deserialize<IEnumerable<Course>>(content);
            if (courses is null)
            {
                throw new ArgumentException("Courses empty");
            }
            var skip = (pageNumber - 1) * pageSize;
            var take = pageSize;
            var courseList = courses.Skip(skip).Take(take);
            return courseList;
        }

        public Task<Course?> GetById(int id)
        {
            throw new NotImplementedException();
        }

        public Task<Course?> Update(int id, Course entity)
        {
            throw new NotImplementedException();
        }
    }
}
